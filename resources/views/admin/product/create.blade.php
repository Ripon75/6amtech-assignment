@extends('welcome')

@section('content')
     <div class="container">
       <div class="row">
            <div class="col-md-10 offset-1">
                <div class="card">
                <div class="card-header">
                    Product Create
                    <a href="{{ route('products.index') }}" class="btn btn-success btn-sm float-end">Products</a>
                </div>
                <div class="card-body">
                    <form>
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input id="input-name" type="text" class="form-control" name="name">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Category</label>
                                    <select id="input-category_id" class="form-select" name="category_id">
                                        <option value="">Select</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Price</label>
                                    <input id="input-price" type="number" class="form-control" name="original_price">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Selling Price</label>
                                    <input id="input-selling_price" type="number" class="form-control" name="selling_price">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tax</label>
                                    <input id="input-tax" type="number" class="form-control" name="tax">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Quantity</label>
                                    <input id="input-quantity" type="number" class="form-control" name="quantity">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Status</label>
                                    <select id="input-status" class="form-select" name="status">
                                        <option value="">Select</option>
                                        <option value="draft">Draft</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <input id="input-description" type="text" class="form-control" name="description">
                                </div>
                            </div>
                        </div>
                         <button id="btn-submit" type="button" class="btn btn-primary float-end">Submit</button>
                    </form>
                </div>
            </div>
        </div>
       </div>
    </div>
@endsection

@push('scripts')
    <script>
        var btnSubmit = $('#btn-submit');
        $(function() {
            btnSubmit.click(function() {
                var name          = $('#input-name').val();
                var categoryId    = $('#input-category_id').val();
                var brandId       = $('#input-brand_id').val();
                var price         = $('#input-price').val();
                var sellingPrice  = $('#input-selling_price').val();
                var tax           = $('#input-tax').val();
                var quantity      = $('#input-quantity').val();
                var status        = $('#input-status').val();
                var description   = $('#input-description').val();

                if (!name) {
                    Toast.fire({
                        icon: 'success',
                        title: 'The name field is required'
                    })
                    return false;
                }
                if (!categoryId) {
                    Toast.fire({
                        icon: 'success',
                        title: 'The category field is required'
                    })
                    return false;
                }
                if (!brandId) {
                    Toast.fire({
                        icon: 'success',
                        title: 'The brand field is required'
                    })
                    return false;
                }
                if (!price) {
                    Toast.fire({
                        icon: 'success',
                        title: 'The price field is required'
                    })
                    return false;
                }
                if (!sellingPrice) {
                    Toast.fire({
                        icon: 'success',
                        title: 'The selling price field is required'
                    })
                    return false;
                }
                if (!quantity) {
                    Toast.fire({
                        icon: 'success',
                        title: 'The quantity field is required'
                    })
                    return false;
                }
                if (!status) {
                    Toast.fire({
                        icon: 'success',
                        title: 'The status field is required'
                    })
                    return false;
                }

                axios.post('/admin/products', {
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