@extends('layouts.adminlte.master', ['noBackButton' => true])

@section('content')
<a href="{{ route('users.create') }}" class="btn btn-primary px-3">
    <i class="fas fa-plus"></i>
    Create
</a>
<div class="card mt-3">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($resources as $resource)
                <tr>
                    <td>{{ $resource->name }}</td>
                    <td>{{ $resource->email }}</td>
                    <td class="text-center">
                        <a href="{{ route('users.edit', $resource->id) }}" class="btn btn-success">
                            <i class="fas fa-edit pr-2"></i>
                            Edit
                        </a>
                        @if (Auth::id() != $resource->id)
                        <a href="{{ route('users.destroy', $resource->id) }}" class="btn btn-danger btn-delete"
                            data-method="delete" data-confirm="Confirm delete {{ $resource->name }}?">
                            <i class="fas fa-trash pr-2"></i>
                            Delete
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection