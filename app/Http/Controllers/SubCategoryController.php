<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        $data = SubCategory::latest()->get();
        return view('admin.subcategory.index')->with('SubCategory', $data);
    }

    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Category = Category::all();
        return view('admin.subcategory.addedit')->with('Category', $Category);
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
            'category_id' => 'required',
            'subcategory' => 'required|max:150|regex:/^[a-zA-Z\s]+$/',
            'slug' => 'required',
        ]);

        $data = $request->all();
        SubCategory::updateOrCreate(['id' => $request->id], $data);
        if ($request->id) {
            toastr()->success('Successfully Update Sub Category!', 'Update Sub Category');
        } else {
            toastr()->success('Successfully Add Sub Category!', 'Add Sub Category');
        }
        return redirect('subcategory');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Category = Category::all();
        $SubCategory = SubCategory::where('id', $id)->first();
        return view('admin.subcategory.addedit')->with('Category', $Category)->with('SubCategory', $SubCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SubCategory::find($id)->delete();

        toastr()->success('Successfully Delete Sub Category!', 'Delete sub Category');
        return back();
    }
}
