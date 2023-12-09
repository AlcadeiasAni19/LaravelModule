<?php

namespace Modules\Products\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Products\app\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public $successStatus = 200;

    //Create new Product
    public function createProduct(Request $request)
    {
        $input = $request->validate([
            "name" => "required|min:3|unique:products",
            "quantity" => "required|integer",
            "stock" => "required|numeric",
            "unit" => "required|string",
            "price" => "required|numeric",
            "user_id" => "required|exists:users,id",
            "category_id" => "required|exists:categories,id"
        ]);
        
        $PostProduct = Product::create($input);
        if ($PostProduct) {
            return response()->json(["status" => $this->successStatus, "result" => $PostProduct]);
        } else {
            return response()->json(["message" => 'Data not found']);
        }
    }

    //List all Products
    public function getAllProduct()
    {
        $ProductList = Product::all();
        return response()->json(["status" => $this->successStatus, 'results' => $ProductList]);
    }

    //Get single Product, with user_name, category_name as well as all reviews
    public function getSingleProduct($product_id)
    {
        $ProductInfo = Product::with("user")->where("id", $product_id)->first();
        $Reviews = Product::find($product_id)->review()->where("product_id",$product_id)->get();
        
        if ($ProductInfo && $Reviews) {
            $Result['product_id'] = $ProductInfo->id; 
            $Result['product_name'] = $ProductInfo->name; 
            $Result['product_quantity'] = $ProductInfo->quantity; 
            $Result['stock'] = $ProductInfo->stock;
            $Result['unit'] = $ProductInfo->unit;
            $Result['price'] = $ProductInfo->price;
            $Result['user_name'] = $ProductInfo->user->name;
            $Result['category_name'] = $ProductInfo->category->name;
            foreach ($Reviews as $reviews){
                $Result['reviews'][] = $reviews->description;
            }
            return response()->json(["status" => $this->successStatus, 'result' => $Result]);
        } else {
            return response()->json(['message' => 'Data not found']);
        }
    }

    //Update normal details of single Product, such as name and category
    public function updateProductDetails (Request $request, $id){
        $getInput = $request->all();

        $validator = Validator::make($request->only("name", "category_id"), [
            "name" => "min:3| unique:products",
            "category_id" => "exists:categories,id"
        ]);

        if ($validator->fails()) {
            $errorMessage = response()->json($validator->errors()->all(), 400);
            return response()->json($errorMessage);
        }

        $ProductUpdate = Product::find($id);
        $ProductUpdate->name = empty($getInput['name'])? $ProductUpdate->name:$getInput['name'];
        $ProductUpdate->category_id = empty($getInput['category_id'])? $ProductUpdate->category_id:$getInput['category_id'];
        if($ProductUpdate->save()){
            return response()->json(["status"=>$this->successStatus,'result'=>$ProductUpdate]);
        } 
        else {
            return response()->json(['message'=>'Data not found']);
        }
    }

    //Update sensitive details of single Product, such as quantity, stock, unit and price
    public function updateProductCredentials (Request $request, $id){
        $getInput = $request->all();

        $validator = Validator::make($request->only("quantity", "stock", "unit", "price"), [
            "quantity" => "numeric",
            "stock" => "numeric",
            "unit" => "string",
            "price" => "numeric",
        ]);

        if ($validator->fails()) {
            $errorMessage = response()->json($validator->errors()->all(), 400);
            return response()->json($errorMessage);
        }

        $ProductUpdate = Product::find($id);
        $ProductUpdate->quantity = empty($getInput['quantity'])? $ProductUpdate->quantity:$getInput['quantity'];
        $ProductUpdate->stock = empty($getInput['stock'])? $ProductUpdate->quantity:$getInput['stock'];
        $ProductUpdate->unit = empty($getInput['unit'])? $ProductUpdate->unit:$getInput['unit'];
        $ProductUpdate->price = empty($getInput['price'])? $ProductUpdate->price:$getInput['price'];
        if($ProductUpdate->save()){
            return response()->json(["status"=>$this->successStatus,'result'=>$ProductUpdate]);
        } 
        else {
            return response()->json(['message'=>'Data not found']);
        }
    }
}
