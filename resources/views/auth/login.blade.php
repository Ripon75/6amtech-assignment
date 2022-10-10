@extends('welcome')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-1">
                <div class="card">
                    <div class="card-header">
                        Login
                        <a href="" class="btn btn-success btn-sm float-end">Register</a>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                               <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Enter Username/Email/Phone</label>
                                        <input id="input-name" type="text" class="form-control">
                                    </div>
                                </div>
                               <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Enter Password</label>
                                        <input id="input-name" type="password" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-sm float-end">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
     <script>
        // Set time to flash message
        setTimeout(function(){
            $("div.alert").remove();
        }, 4000 );
    </script>
@endpush