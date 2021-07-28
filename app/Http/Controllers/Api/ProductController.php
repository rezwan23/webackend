<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(['products' => Product::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' =>  'required',
            'description'   =>  'required',
            'image' =>  'required|image|max:220',
            'price' =>  'required|numeric'
        ]);

        $file = $request->file('image');
        $fileName = storeFile($file, 'products');


        Product::create(array_merge($request->except('image'), ['image' => $fileName]));

        return response(['message' => 'Product Created!']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response(['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validationArr = [
            'title' =>  'required',
            'description'   =>  'required',
            'price' =>  'required|numeric'
        ];

        if($request->hasFile('image')){
            $validationArr = array_merge($validationArr, ['image' => 'image|max:220']);
        }

        $request->validate($validationArr);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileName = storeFile($file, 'products');

            Storage::delete($product->image);
        }else{
            $fileName = $product->image;
        }

        $product->update(array_merge($request->except('image'), ['image' => $fileName]));

        return response(['message' => 'Product Updated!']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Storage::delete($product->image);
        $product->delete();

        return response(['message' => 'Product Deleted!']);
    }
}
