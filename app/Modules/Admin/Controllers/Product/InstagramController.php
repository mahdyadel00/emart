<?php

namespace App\Modules\Admin\Controllers\Product;

use App\Bll\Constants;
use App\Models\product\product_details;
use App\Models\product\product_photos;
use App\Models\product\products;
use App\Modules\Admin\Controllers\Admin\Product\Controller;
use App\Modules\Admin\Controllers\Admin\Product\Lang;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use function _i;
use function App\Modules\Admin\Controllers\Admin\Product\get_store_id;
use function App\Modules\Admin\Controllers\Admin\Product\public_path;
use function config;
use function redirect;

class InstagramController extends Controller
{
    public function redirectTo()
    {
        $appId = config('services.instagram.client_id');
        $redirectUri = urlencode(config('services.instagram.redirect'));
        return redirect()->to("https://api.instagram.com/oauth/authorize?app_id={$appId}&redirect_uri={$redirectUri}&scope=user_profile,user_media&response_type=code");
    }

    public function Callback(Request $request)
    {
        $code = $request->code;
        if (empty($code)) return redirect()->route('products.index')->with('error', _i('Failed to Connect to Instagram.'));

        $appId = config('services.instagram.client_id');
        $secret = config('services.instagram.client_secret');
        $redirectUri = config('services.instagram.redirect');

        $client = new Client();

        // Get access token
        $response = $client->request('POST', 'https://api.instagram.com/oauth/access_token', [
            'form_params' => [
                'app_id' => $appId,
                'app_secret' => $secret,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $redirectUri,
                'code' => $code,
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            return redirect()->route('products.index')->with('error', _i('Failed to Connect to Instagram.'));
        }
        $content = $response->getBody()->getContents();
        $content = json_decode($content);

        $accessToken = $content->access_token;
        $userId = $content->user_id;

        // Get user info
        $response = $client->request('GET', "https://graph.instagram.com/me?fields=id,username,account_type&access_token={$accessToken}");

        $content = $response->getBody()->getContents();
        $oAuth = json_decode($content);

        // Get instagram user name
        $username = $oAuth->username;

        // do your code here

        // Get user images
        $media = $client->request('GET', "https://graph.instagram.com/me/media?fields=id,media_type,media_url&access_token={$accessToken}");

        $image_content = $media->getBody()->getContents();
		$images = json_decode($image_content);

        foreach ($images as $image) {
            foreach ($image as $item) {
                $this->createProduct($item);
            }
        }

        return redirect()->route('products.index')->with('success', _i('Imported Successfully !'));

    }

    private function createProduct($item)
    {
        DB::beginTransaction();
        try {
            $store = get_store_id();
            $newProduct = products::create([
                'currency_code' => Constants::defaultCurrency,

            ]);

            $product_details = product_details::create([

                'title' => 'import from instagram',
                'product_id' => $newProduct->id,
                'lang_id' => Lang::getSelectedLangId(),

            ]);

            $path = parse_url($item->media_url, PHP_URL_PATH);       // get path from url
            $extension = pathinfo($path, PATHINFO_EXTENSION); // get ext from path
            $filename = pathinfo($path, PATHINFO_FILENAME); // get name from path
            $imageName = $filename . '.' . $extension;

            if (!is_dir(public_path('uploads/products/' . $newProduct->id))) {
                mkdir(public_path('uploads/products/' . $newProduct->id), 755, true);
            }

            Image::make($item->media_url)->save(public_path('/uploads/products/' . $newProduct->id . '/' . $imageName));

            product_photos::create([

                'product_id' => $newProduct->id,
                'photo' => '/uploads/products/' . $newProduct->id . '/' . $imageName,
                'description' => $filename,
                'tag' => $filename,
                'main' => 1,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
