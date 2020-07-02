<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //with PER LE RELAZIONI CON ALTRE TABLE/MODEL
//        return Category::with('albums')->get();

//        $categories = Category::where('user_id', Auth::id())->withCount('albums')->latest()->paginate(5);
//        $categories = Auth::user()->albumCategories()->withCount('albums')->latest()->paginate(5);
        $categories = Category::getCategoriesByUserId(auth()->user())->latest()->paginate();
//        return $categories; //666666666666666

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();
//        dd($category);
        return view('categories.editcategory', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //GLI ARRIVA ANCHE LA CATEGORIA DAL FORM
    //CON CategoryRequest E' PROTETTO LATO php DA INPUT NULL SUL FORM
    //CON required SUL CAMPO INPUT E' PROTETTO LATO client
    //LATO DB E' GIA' PROTETTO DAL CAMPO not null
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->category_name = $request->category_name;
        $category->user_id = Auth::id();
        $res = $category->save();

        if ($request->expectsJson()){
            return [
                'message' => $res ? 'Categoria creata con ajax':'errore creazione ajax',
                'success' => (bool) $res,
                'data' =>$category  //LO SFRUTTO DENTRO AJAX PER CLONARE LA RIGA
            ];
        } else {
            return redirect()->route('categories.index');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.editcategory', compact('category'));
//        return view('categories.editcategory', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

        $category->category_name = $request->category_name;
//        $category->category_name = $request->input('category_name');
        $res = $category->save();

        if ($request->expectsJson()){
            return [
                'message' => $res ? 'Categoria modificata con ajax':'errore modifica ajax',
                'success' => (bool) $res,
                'data' =>$category  //LO SFRUTTO DENTRO AJAX PER CLONARE LA RIGA
            ];
        } else {
            return redirect()->route('categories.index');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Request $request)
    {
        $res = $category->delete();

        if($request->expectsJson()) { //VERIFICA SE E' UNA CHIAMATA AJAX
            return [
                'message' => $res ? 'Categoria eliminata con ajax':'errore eliminazione ajax',
                'success' => (bool) $res
            ];
        } else {
            return redirect()->route('categories.index');
        }

    }
}



