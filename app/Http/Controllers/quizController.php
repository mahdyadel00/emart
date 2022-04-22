<?php

namespace App\Http\Controllers;

class quizController extends Controller
{

    public function index(){

        $word = "{{(}}}";
        $length = strlen($word);
        if($length % 2 != 0){
            return "fail";
        }
        $half =  str_split($word, $length/2);

        $arr1 = str_split($half[0]);
        $arr2 = str_split($half[1]);
        $reverse = array_reverse($arr2);

      //  $all = array_merge($arr1,$reverse);
       // $word_merg = array_merge(str_split ($word));

        $result = array_diff_assoc($arr2,$reverse);
        dd($result);

        //$half = $word / 2;
       // dd($all, $word_merg );
        //dd(array_diff_assoc($arr1,$reverse));
//        if($result == null ){
//            return  "success" ?? "fail";
//        }

    }

    function identical_values( $arrayA , $arrayB ) {

        sort( $arrayA );
        sort( $arrayB );

        return $arrayA == $arrayB;
    }
}
