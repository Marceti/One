@if (count($errors))
    @foreach($errors->all() as $error)
        <p>{{$error}}</p>
    @endforeach
@endif