@if (Session::has('message'))
    @foreach(Session::get('message') as $message)
    <div id="flash-message" class="alert alert-success" role="alert">
        {{ $message }}
    </div>
    @endforeach
@endif