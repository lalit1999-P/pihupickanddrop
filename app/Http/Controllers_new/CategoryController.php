<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        $data = Category::latest()->get();
        return view('admin.category.index')->with('Category', $data);
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
        return view('admin.category.addedit');
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
            'category' => 'required|regex:/^[a-zA-Z\s]+$/',
            'slug' => 'required',
            'description' => 'required|max:250',
        ]);

        $data = $request->all();
        Category::updateOrCreate(['id' => $request->id], $data);
        if ($request->id) {
            toastr()->success('Successfully Update Category!', 'Update Category');
        } else {
            toastr()->success('Successfully Add Category!', 'Add Category');
        }
        return redirect('category');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Category = Category::where('id', $id)->first();
        return view('admin.category.addedit')->with('Category', $Category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::find($id)->delete();

        toastr()->success('Successfully Delete Category!', 'Delete Category');
        return back();
    }
}
