<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controller as BaseController;

class CategoryController extends BaseController {
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $category = Category::OrderBy("id", "ASC")->paginate(10)->toArray();

        if (!$category) {
            abort(404);
        }
        
        return view('admin.category.index')->with(['categories'=>$category['data']]);
    }

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function findById(Request $request, $id) {
        $category = Category::find($id);
        
        if (!$category) {
            abort(404);
        } else {
            return response()->json($category, 200);
        }
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function storeView()
    {
        return view('admin.category.store');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function store(Request $request) {
        $input = $request->all();

        $validationRules = [
            'name' => 'required|unique:categories',
            'description' => 'required'
        ];

        $validator = Validator::make($input, $validationRules);

        if ($validator->fails()) {
          return view('admin.category.store')->with(['errors'=>$validator->errors()]);
        }

        $category = new Category;
        $category->name = $request->input('name');
        $category->description = $request->input('description');
            
        $category->save();                                

        $categories = Category::all();
        return view('admin.category.index')->with(['categories'=>$categories, 'messages' => 'Category Successfully Created!']);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
      $category = Category::find($id);
      
      if (!$category) {
          abort(404);
      }

      $input = $request->all();

      $validationRules =[
          'name' => 'required|unique:categories',
          'description' => 'required'
      ];
      
      $validator = Validator::make($input,$validationRules);
      
      if ($validator->fails()) {
          return response()->json($validator->errors(), 400);
      }

      $category->fill($input);
      $category->save();
      return response()->json($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {
      $category = Category::find($id);
      
      if(!$category) {
          abort(404);
      }
      
      $category->delete();

      $categories = Category::all();
      return view('admin.category.index')->with(['categories'=>$categories]);
    }
}
?>