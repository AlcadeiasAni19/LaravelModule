<?php

namespace Modules\Carts\app\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Carts\app\Models\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CartsController extends Controller
{
    public $successStatus = 200;

    //Add products to a cart
    public function addProduct(Request $request)
    {
        $input = $request->all();
        $size = count($input["product_id"]);
        $validator = Validator::make($request->all(),[
            "product_id" => "required|array",
            "product_id.*" => "exists:products,id|distinct",
            "product_quantity" => "required|array|size: $size",
            "product_quantity.*" => "numeric",
            "user_id" => "required|exists:users,id"
        ]);
        
        if ($validator->fails()) {
            $errorMessage = response()->json($validator->errors()->all(), 400);
            return response()->json($errorMessage);
        }

        // Check if User has any Cart
        $cart_exists = Cart::where("user_id",$input['user_id'])->get();
        if(count($cart_exists) > 0) {
            // Clear old cart
            for($i=0; $i<count($cart_exists); $i++) {
                $deleteOldCart = Cart::find($cart_exists[$i]->id);
                $deleteOldCart->delete();
            }
        }
        
        foreach ($input['product_id'] as $product) {
            $cart = new Cart;
            $cart["user_id"] = $input['user_id'];
            $cart["product_id"] = $product;
            $cart["product_quantity"] = $input["product_quantity"][array_search($product, $input['product_id'])];
            $cart->save();
        }

        // if(empty($checkUserCart)) {
        //     $postCart = Cart::create($input);
        //     foreach ($input['product_id'] as $product) {
        //         $NewCart["cart_id"] = $postCart["id"];
        //         $NewCart["product_id"] = $product;
        //         CarthasProduct::create($NewCart); 
        //     }
        // } else {
        //     $count = 0;
        //     foreach ($input['product_id'] as $product) {
        //         $SearchDuplicate = CarthasProduct::where("cart_id", $is_cart_exists["id"])->where("product_id", $product)->exists();
        //         if ($SearchDuplicate==false) {
        //             $count = $count + 1;
        //             $NewCart["cart_id"] = $is_cart_exists["id"];
        //             $NewCart["product_id"] = $product;
        //             CarthasProduct::create($NewCart);
        //         }
        //     }
        // }

        if ($cart) {
            return response()->json(["status" => $this->successStatus, "message" => "Added to Cart successfully"]);
        } else {
            return response()->json(["message" => 'Data not found']);
        }
    }

    //List all Carts
    public function getAllCart()
    {
        $CartList = Cart::all();
        return response()->json(["status" => $this->successStatus, 'results' => $CartList]);
    }
}
