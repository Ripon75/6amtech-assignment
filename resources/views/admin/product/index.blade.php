@extends('welcome')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-1">
                <div class="card">
                    <div class="card-header">
                        Product List
                        <a href="{{ route('products.create') }}" class="btn btn-success btn-sm float-end">Create</a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Brand</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Selling Price</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td >{{ $product->category->name ?? '' }}</td>
                                    <td >{{ $product->brand->name ?? '' }}</td>
                                    <td >{{ $product->price }}</td>
                                    <td>{{ $product->selling_price }}</td>
                                    <td>{{ $product->status }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-success btn-sm">
                                            Edit
                                        </a>
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm">
                                            Show
                                        </a>
                                        <button class="btn-delete btn btn-danger btn-sm m-2" 
                                            data-product-id="{{ $product->id }}">
                                            Delete
                                        </button>
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

@push('styles')
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <script>

        btnDelete = $('.btn-delete');

        $(function() {
            btnDelete.click(function() {
                Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    var productID = $(this).data('product-id');
                    deleteProduct(productID);
                }
            });
               
            });
        });

        function deleteProduct(productID) {
            axios.delete(`/admin/products/${productID}`)
            .then(res => {
                location.reload();
            })
            .catch(err => {
                console.log(err);
            });
        }
    </script>
@endpush