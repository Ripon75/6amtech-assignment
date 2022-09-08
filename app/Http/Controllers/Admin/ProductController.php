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
use DB;
use Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])
        ->orderBy('created_at', 'desc')->get();

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
        $tax           = $request->input('tax', 0);
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
        $productObj->tax            = $tax ?? 0;
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
        $tax           = $request->input('tax', 0);
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
        $productObj->tax            = $tax ?? 0;
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

    // Product bulk upload function
    public function bulk(Request $request)
    {
        return view('admin.product.bulk');
    }

    public function bulkUpload(Request $request)
    {
        // $request->validate([
        //     'uploaded_file' => ['file', 'mimes:csv']
        // ]);

        $file = $request->file('uploaded_file');

        $filename  = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();  //Get extension of uploaded file
        $tempPath  = $file->getRealPath();
        $fileSize  = $file->getSize();                     //Get size of uploaded file in bytes
        //Check for file extension and size
        $this->checkUploadedFileProperties($extension, $fileSize);
        //Where uploaded file will be stored on the server
        $location = 'uploads'; //Created an "uploads" folder for that
        // Upload file
        $file->move($location, $filename);
        // In case the uploaded file path is to be stored in the database
        $filepath = public_path($location . "/" . $filename);
        // Reading file
        $file = fopen($filepath, "r");

        $firstline = true;

        while (($data = fgetcsv($file, 500, ",")) !== false) {
            if (!$firstline) {
                // Get All data from csv
                $productName  = trim($data['0']);
                $categoryName = trim($data['1']);
                $brandName    = trim($data['2']);
                $price        = trim($data['3']);
                $sellingPrice = trim($data['4']);
                $tax          = trim($data['5']);
                $quantity     = trim($data['6']);
                $status       = trim($data['7']);
                $description  = trim($data['8']);

                $price        = (float)$price;
                $sellingPrice = (float)$sellingPrice;

                $categoryID = null;
                if ($categoryName) {
                    $category = Category::where('name', $categoryName)->first();
                    if ($category) {
                        $categoryID = $category->id;
                    } else {
                        $slug = Str::slug($categoryName, '-');
                        try {
                            DB::beginTransaction();
                            $categoryObj          = new Category();
                            $categoryObj->slug    = $slug;
                            $categoryObj->name    = $categoryName;
                            $categoryObj->status  = 1;
                            $categoryObj->popular = 1;
                            $categoryObj->save();
                            $categoryID = $categoryObj->id;
                            DB::commit();
                        } catch (\Exception $e) {
                            DB::rollBack();
                        }
                    }
                }

                $brandID = null;
                if ($brandName) {
                    $brand = Brand::where('name', $brandName)->first();
                    if ($brand) {
                        $brandID = $brand->id;
                    } else {
                        $slug = Str::slug($brandName, '-');
                        try {
                            DB::beginTransaction();
                            $brandObj          = new Brand();
                            $brandObj->slug    = $slug;
                            $brandObj->name    = $brandName;
                            $brandObj->status  = 1;
                            $brandObj->popular = 1;
                            $brandObj->save();
                            $brandID = $brandObj->id;
                            DB::commit();
                        } catch (\Exception $e) {
                            DB::rollBack();
                        }
                    }
                }

                if ($productName && $price) {
                    $slug = Str::slug($productName, '-');
                    try {
                        DB::beginTransaction();
                        $productObj                = new Product();
                        $productObj->name          = $productName;
                        $productObj->slug          = $slug;
                        $productObj->category_id   = $categoryID;
                        $productObj->brand_id      = $brandID;
                        $productObj->price         = $price;
                        $productObj->selling_price = $sellingPrice;
                        $productObj->tax           = $tax ?? 0;
                        $productObj->quantity      = $quantity;
                        $productObj->status        = $status;
                        $productObj->description   = $description ?? null;
                        $productObj->save();
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                    }
                }
            }
            $firstline = false;
        }

        fclose($file);

        return back()->with('message', 'File upload succesfully done');
    }

    public function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extension = ['csv']; //Only want csv and excel files
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {
            } else {
                throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
            }
        } else {
            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error
        }
    }
}
