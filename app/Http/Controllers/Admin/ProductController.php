<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utility\CommonUtils;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])->get();

        return view('admin.product.index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        $brands     = Brand::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();

        return view('admin.product.create', [
            'brands'     => $brands,
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'           => ['required'],
            'category_id'    => ['required'],
            'brand_id'       => ['required'],
            'price'          => ['required'],
            'selling_price'  => ['required'],
            'quantity'       => ['required'],
            'status'         => ['required']
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            return CommonUtils::sendError($validator->errors(), __('common.validationErr'));
        }

        $name          = $request->input('name', null);
        $categoryID    = $request->input('category_id', null);
        $brandID       = $request->input('brand_id', null);
        $price         = $request->input('price', null);
        $sellingPrice  = $request->input('selling_price', null);
        $tax           = $request->input('tax', null);
        $quantity      = $request->input('quantity', null);
        $status        = $request->input('status', null);
        $description   = $request->input('description', null);
        $slug          = Str::slug($name, '-');

        $productObj = new Product();

        $productObj->name           = $name;
        $productObj->slug           = $slug;
        $productObj->category_id    = $categoryID;
        $productObj->brand_id       = $brandID;
        $productObj->price          = $price;
        $productObj->selling_price  = $sellingPrice;
        $productObj->tax            = $tax;
        $productObj->quantity       = $quantity;
        $productObj->status         = $status;
        $productObj->description    = $description;
        $res = $productObj->save();
        if ($res) {
            return CommonUtils::sendResponse($productObj, __('product.create'));
        } else {
            return CommonUtils::sendError(null, __('product.failed'));
        }
    }

    public function show($id)
    {
        $product = Product::find($id);

        return view('admin.product.show', [
            'product' => $product
        ]);
    }


    public function edit($id)
    {
        $product    = Product::find($id);
        $brands     = Brand::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();

        return view('admin.product.edit', [
            'product'    => $product,
            'brands'     => $brands,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'           => ['required'],
            'category_id'    => ['required'],
            'brand_id'       => ['required'],
            'price'          => ['required'],
            'selling_price'  => ['required'],
            'quantity'       => ['required'],
            'status'         => ['required']
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            return CommonUtils::sendError($validator->errors(), __('common.validationErr'));
        }

        $name          = $request->input('name', null);
        $categoryID    = $request->input('category_id', null);
        $brandID       = $request->input('brand_id', null);
        $price         = $request->input('price', null);
        $sellingPrice  = $request->input('selling_price', null);
        $tax           = $request->input('tax', null);
        $quantity      = $request->input('quantity', null);
        $status        = $request->input('status', null);
        $description   = $request->input('description', null);
        $slug          = Str::slug($name, '-');

        $productObj = Product::find($id);

        $productObj->name           = $name;
        $productObj->slug           = $slug;
        $productObj->category_id    = $categoryID;
        $productObj->brand_id       = $brandID;
        $productObj->price          = $price;
        $productObj->selling_price  = $sellingPrice;
        $productObj->tax            = $tax;
        $productObj->quantity       = $quantity;
        $productObj->status         = $status;
        $productObj->description    = $description;
        $res = $productObj->save();
        if ($res) {
            return CommonUtils::sendResponse($productObj, __('product.update'));
        } else {
            return CommonUtils::sendError(null, __('product.failed'));
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $res = $product->delete();

            if ($res) {
                return CommonUtils::sendResponse($res, __('product.delete'));
            } else {
                return CommonUtils::sendError(null, __('product.failed'));
            }
        } else {
            return false;
        }
    }

    public function getProduct(Request $request)
    {
        $startPrice = $request->input('start_price', null);
        $endPrice   = $request->input('end_price', null);
        $status     = $request->input('status', null);
        $order      = $request->input('order', null);

        $products = Product::with(['category:id,name', 'brand:id,name']);

        if ($startPrice && $endPrice) {
            // filter using scope
            $products = $products->priceRageWiseFilter($startPrice, $endPrice);
        }

        if ($status) {
            $products = $products->where('status', $status);
        }

        if ($order) {
            $products = $products->orderBy('price', $order);
        }

        $products = $products->get();

        if (count($products) > 0) {
            return CommonUtils::sendResponse($products, __('product.list'));
        } else {
            return CommonUtils::sendError(null, __('product.notFound'));
        }
    }
}
