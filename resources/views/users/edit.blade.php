@extends('layouts.adminlte.master', ['noBackButton' => true])

@section('content')
<form action="{{ route('users.update', $resource->id) }}" method="post">
    @include('users.content')
</form>
@endsection
