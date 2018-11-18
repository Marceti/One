@if (count($errors))
    @foreach($errors->all() as $error)
        <div id="flash-message" class="alert alert-danger" role="alert">
            {{ $error }}
        </div>
    @endforeach
@endif