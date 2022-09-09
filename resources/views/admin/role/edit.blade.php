@extends('welcome')

@section('content')
     <div class="container">
       <div class="row">
            <div class="col-md-10 offset-1">
                {{-- Flash message --}}
                @if(Session::has('message'))
                    <div class="alert alert-danger">{{ Session::get('message') }}</div>
                @endif
                <div class="card">
                <div class="card-header">
                    Role Create
                    <a href="{{ route('roles.index') }}" class="btn btn-success btn-sm float-end">Roles</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Display Name</label>
                                    <input type="text" class="form-control" name="display_name" value="{{ $role->display_name }}">
                                    @error('display_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="description" value="{{ $role->description }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                @foreach ($permissions as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="permission_ids[]" value="{{ $permission->id }}"
                                        {{ in_array($permission->id, $permission_ids) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        {{ $permission->display_name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-end">Update</button>
                    </form>
                </div>
            </div>
        </div>
       </div>
    </div>
@endsection