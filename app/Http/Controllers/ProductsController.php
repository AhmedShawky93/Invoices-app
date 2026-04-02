<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = sections::all();
        $products = products::with('section')->latest()->get();

        return view('products.products', compact('sections', 'products'));
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
        
        $validatedData = $request->validate([
            'product_name' => 'required|unique:products|max:255',
            'description' =>'required', 
            'section_id' => 'required',
        ],
        [
            'product_name.required' =>'برجاء ادخال اسم المنتج',
            'product_name.unique' =>'اسم المنتج مسجل مسبقا',
            'description.required' =>'برجاء ادخال الشرح',
            'section_id.required' =>'برجاء اختيار القسم',
        ]);
        products::create([
            'Product_name'=> $request->product_name,
            'section_id'=> $request->section_id,
            'description' => $request ->description,
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $this->validate($request, [
            'product_name' => 'required|max:255|unique:products,Product_name,' . $id,
            'description' => 'required',
            'section_id' => 'required|exists:sections,id',
        ], [
            'product_name.required' => 'برجاء ادخال اسم المنتج',
            'product_name.unique' => 'اسم المنتج مسجل مسبقا',
            'description.required' => 'برجاء ادخال الشرح',
            'section_id.required' => 'برجاء اختيار القسم',
        ]);

        $product = products::findOrFail($id);
        $product->update([
            'Product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $request->section_id,
        ]);

        session()->flash('edit', 'تم تعديل المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        products::findOrFail($request->id)->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return redirect('/products');
    }
}
