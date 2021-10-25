<?php
namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controller as BaseController;

class ProductController extends BaseController {
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
  }

  /**
   * Display a listing of the resource.
   * 
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request) {
    $product = Product::OrderBy("id", "DESC")->paginate(10)->toArray();

    if (!$product) {
        abort(404);
    }

    $response = [
      "total_count" => $product["total"],
      "limit" => $product["per_page"],
        "pagination" => [
            "next_page" => $product["next_page_url"],
            "current_page" => $product["current_page"]
        ],
        "data" => $product,
    ];
    
    return view("admin.product.index", ['products' => $product['data']]);
  }

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function findById(Request $request, $id) {
        $product = Product::find($id);
        
        if (!$product) {
            abort(404);
        } else {
            return response()->json($product, 200);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function storeView()
    {
        $categories = Category::all();

        return view('admin.product.store')->with(['categories'=>$categories]);
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
            'name' => 'required|unique:products',
            'description' => 'required',
            'price' => 'required',
            'images' => 'required',
        ];

        $validator = Validator::make($input, $validationRules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product = new Product;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        if ($request->hasFile('images')) {
            $filenameWithExt = $request->file('images')->getClientOriginalName ();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('images')->getClientOriginalExtension();
            $fileNameToStore = 'product_'. time().'.'.$extension;
        } else {
          $fileNameToStore = 'noimage.jpg';
        }
        
        $request->file('images')->move(storage_path('assets/images'),$fileNameToStore);
        $product->images = $fileNameToStore;
            
        $product->save();
        return response()->json($product, 200);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
      $product = Product::find($id);
      
      if (!$product) {
          abort(404);
      }

      $input = $request->all();

      $validationRules =[
        'name' => 'required|unique:products',
        'description' => 'required',
        'price' => 'required',
      ];
      
      $validator = Validator::make($input,$validationRules);
      
      if ($validator->fails()) {
          return response()->json($validator->errors(), 400);
      }

      if ($request->hasFile('images')) {
        $filenameWithExt = $request->file('images')->getClientOriginalName ();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('images')->getClientOriginalExtension();
        $fileNameToStore = 'product_'. time().'.'.$extension;
        $input->images = $fileNameToStore;
      }

      $product->fill($input);
      $product->save();
      return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {
      $product = Product::find($id);
      
      if(!$product) {
          abort(404);
      }
  
      $product->delete();

      $response = [
          'message' => 'Deleted Successfully!',
          'product_id' => $id
      ];
  
      // Response Accept : 'application/json'
      return response()->json($response, 200);
    }
}
?>