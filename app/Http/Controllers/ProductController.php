<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Size;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use ImageUpload;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()){
            if (!empty($request->search)){
                $products = $user->products()->where('name', 'like', '%' . $request->search . '%')->paginate(10);
            }else{
                $products = $user->products()->paginate(10);
            }
            $view = view('product.render',compact('products'))->render();
            return response()->json(['html'=>$view,'status'=>'success','count'=>count($products)]);
        }
        $products = $user->products()->paginate(10);
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sizes = Size::all();
        return view('product.create', compact('sizes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $msg = [
            'image.required' => 'Please Select Image',
            'name.required' => 'Please Enter Name',
        ];
        $validator = Validator::make($request->all(), [
            'image' => 'required',
            'name' => 'required',
        ], $msg);
        if ($validator->passes()) {
            try {
                $path = 'images/product/';
                $image = $this->saveImage($path, $request->image);

                $product = new Product();
                $product->user_id = Auth::id();
                $product->unique_id = $request->unique_id;
                $product->name = $request->name;
                $product->image = $path . $image;
                $product->save();

                if (!empty($request->size)) {
                    $count = 0;
                    foreach ($request->size as $size) {
                        $productSize = new ProductSize();
                        $productSize->product_id = $product->id;
                        $productSize->size_id = $size;
                        $productSize->cost = $request->price[$count];
                        $productSize->save();
                        $count++;
                    }
                }
                return response()->json(['status' => 'success', 'msg' => 'Item Created Successfully']);
            } catch (Exception $exception) {
                return response()->json(['status' => 'error', 'msg' => $exception->getMessage()]);
            }
        } else {
            return response()->json(['status' => 'errors', 'msg' => $validator->errors()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $sizes = Size::all();
        $productSize = ProductSize::whereProductId($product['id'])->get();
        return view('product.edit',compact('product','sizes','productSize'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $msg = [
            'name.required' => 'Please Enter Name',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], $msg);
        if ($validator->passes()) {
            try {
                if (!empty($request->image)){
                    $path = 'images/product/';
                    $image = $this->saveImage($path, $request->image);
                    $image = $path . $image;
                }else{
                    $image = $product['image'];
                }

                $product->name = $request->name;
                $product->image = $image;
                $product->save();

                if (!empty($request->size)) {
                    $count = 0;
                    $ids = [];
                    $productSizeIds = ProductSize::whereProductId($product['id'])->pluck('id')->toArray();
                    foreach ($request->size as $size) {
                        $productSize = ProductSize::whereProductId($product['id'])->whereSizeId($size)->first();
                        if (empty($productSize)){
                            $productSize = new ProductSize();
                            $productSize->product_id = $product->id;
                        }else{
                            $ids[] = $productSize['id'];
                        }
                        $productSize->size_id = $size;
                        $productSize->cost = $request->price[$count];
                        $productSize->save();
                        $count++;
                    }
                    $data = array_diff($productSizeIds,$ids);
                    ProductSize::whereIn('id',$data)->delete();
                }
                return response()->json(['status' => 'success', 'msg' => 'Item Updated Successfully']);
            } catch (Exception $exception) {
                return response()->json(['status' => 'error', 'msg' => $exception->getMessage()]);
            }
        } else {
            return response()->json(['status' => 'errors', 'msg' => $validator->errors()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back()->with('success','Item Deleted Successfully');
    }
}
