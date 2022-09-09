@extends('welcome')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-1">
                <div class="card">
                    <div class="card-header">
                        Permission List
                        <a href="{{ route('permissions.create') }}" class="btn btn-success btn-sm float-end">Create</a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->description }}</td>
                                    <td>
                                        <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-success btn-sm">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection