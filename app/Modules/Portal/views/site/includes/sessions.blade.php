@if(session()->has('success'))
    <div class="container py-2">
        <div class="alert alert-success">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>{{_i('Success')}}!</strong> {{ session()->get('success') }}.
        </div>
    </div>
@endif
@if(session()->has('error'))
    <div class="container py-2">
        <div class="alert alert-danger">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>{{_i('Error')}}!</strong> {{ session()->get('error') }}.
        </div>
    </div>
@endif
