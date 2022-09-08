@extends('welcome')

@section('content')
     <div class="container">
       <div class="row">
            <div class="col-md-10 offset-1">
                <div class="card">
                <div class="card-header">
                    Product Edit
                    <a href="{{ route('products.index') }}" class="btn btn-success btn-sm float-end">Products</a>
                </div>
                <div class="card-body">
                    <form>
                        @csrf
                        <div class="row">
                            <input id="input-product-id" type="hidden" value="{{ $product->id }}">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input id="input-name" type="text" class="form-control" value="{{ $product->name }}">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Category</label>
                                    <select id="input-category_id" class="form-select" name="category_id">
                                        <option value="">Select</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Brand</label>
                                    <select id="input-brand_id" class="form-select" name="brand_id">
                                        <option value="">Select</option>
                                        @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Price</label>
                                    <input id="input-price" type="number" class="form-control" value="{{ $product->price }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Selling Price</label>
                                    <input id="input-selling_price" type="number" class="form-control" value="{{ $product->selling_price }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tax</label>
                                    <input id="input-tax" type="number" class="form-control" value="{{ $product->tax }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Quantity</label>
                                    <input id="input-quantity" type="number" class="form-control" value="{{ $product->quantity }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Status</label>
                                    <select id="input-status" class="form-select" name="status">
                                        <option value="">Select</option>
                                        <option value="draft" {{ $product->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $product->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <input id="input-description" type="text" class="form-control" value="{{ $product->description }}">
                                </div>
                            </div>
                        </div>
                         <button id="btn-update" type="button" class="btn btn-primary float-end">Update</button>
                    </form>
                </div>
            </div>
        </div>
       </div>
    </div>
@endsection

@push('scripts')
    <script>
        var btnSubmit     = $('#btn-update');
        $(function() {
            btnSubmit.click(function() {
                var productID     = $('#input-product-id').val();
                var name          = $('#input-name').val();
                var categoryId    = $('#input-category_id').val();
                var brandId       = $('#input-brand_id').val();
                var price         = $('#input-price').val();
                var sellingPrice  = $('#input-selling_price').val();
                var tax           = $('#input-tax').val();
                var quantity      = $('#input-quantity').val();
                var status        = $('#input-status').val();
                var description   = $('#input-description').val();

                axios.put(`/admin/products/${productID}`, {
                    name: name,
                    category_id: categoryId,
                    brand_id: brandId,
                    price: price,
                    selling_price: sellingPrice,
                    tax: tax,
                    quantity: quantity,
                    status: status,
                    description: description
                })
                .then(function (res) {
                    window.location.href = "/admin/products";
                })
                .catch(function (err) {
                    console.log(err);
                });
            });
        });
    </script>
@endpush