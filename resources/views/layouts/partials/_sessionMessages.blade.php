@if (session()->has('message'))
    <div id="flash-message" class="alert alert-success" role="alert">
        {{ session('message') }}
    </div>
@endif