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
                    Permission Create
                    <a href="{{ route('permissions.index') }}" class="btn btn-success btn-sm float-end">Products</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Display Name</label>
                                    <input type="text" class="form-control" name="display_name">
                                </div>
                                @error('display_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="description">
                                </div>
                            </div>
                        </div>
                         <button type="submit" class="btn btn-primary float-end">Submit</button>
                    </form>
                </div>
            </div>
        </div>
       </div>
    </div>
@endsection