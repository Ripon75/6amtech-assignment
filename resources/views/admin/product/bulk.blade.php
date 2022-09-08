@extends('welcome')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-1">
                {{-- Flash message --}}
                @if(Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        Product Bulk Upload
                        <a href="{{ route('products.index') }}" class="btn btn-success btn-sm float-end">Products</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.bulk.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="">
                                <input type="file" name="uploaded_file" id="file" accept=".csv">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
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