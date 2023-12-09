<?php

namespace Modules\Products\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Products\app\Models\Wishlist;

class WishlistController extends Controller
{
    public $successStatus = 200;

    //Add to Wishlist
    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "product_id" => "required|array",
            "product_id.*" => "exists:products,id|distinct",
            "user_id" => "required|exists:users,id"
        ]);

        if ($validator->fails()) {
            $errorMessage = response()->json($validator->errors()->all(), 400);
            return response()->json($errorMessage);
        }
        $input = $request->all();
        $count = 0;
        foreach ($input['product_id'] as $product) {
            $SearchDuplicate = Wishlist::where("user_id", $input['user_id'])->where("product_id", $product)->exists();
            if ($SearchDuplicate==false) {
                $count = $count + 1;
                $RawProduct["user_id"] = $input["user_id"];
                $RawProduct["product_id"] = $product; 
                Wishlist::create($RawProduct);
            }
        }
        
        if ($count>=1) {
            return response()->json(["status" => $this->successStatus, "message" => "Added successfully"]);
        } else {
            return response()->json(["message" => 'All duplicates']);
        }
    }

    //List all Wishlists
    public function getAllWishlist()
    {
        $WishlistList = Wishlist::all();
        return response()->json(["status" => $this->successStatus, 'results' => $WishlistList]);
    }

    //Delete a product from Wishlist 
    public function deleteProductWishlist(Request $request)
    {
        $input = $request->validate([
            "product_id" => "required|array",
            "product_id.*" => "distinct",
            "user_id" => "required|exists:users,id"
        ]);

        $count = 0;
        foreach ($input['product_id'] as $product) {
            $count = $count + 1;
            Wishlist::where("user_id", $input['user_id'])->where("product_id", $product)->delete();
        }
        return response()->json(["status" => $this->successStatus, "message" => "Deleted $count records successfully"]);
    }
}
