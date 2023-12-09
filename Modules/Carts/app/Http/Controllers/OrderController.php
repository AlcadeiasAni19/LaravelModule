<?php

namespace Modules\Carts\app\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Carts\app\Models\Cart;
use Modules\Carts\app\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Validator;
use Modules\Carts\app\Models\OrderhasProduct;
use Modules\Products\app\Models\Wishlist;

class OrderController extends Controller
{
    public $successStatus = 200;

    //add Order
    public function createOrder(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($request->only("confirmation"), [
            "confirmation" => "required|in:yes,no"
        ]);

        if ($validator->fails()) {
            $errorMessage = response()->json($validator->errors()->all(), 400);
            return response()->json($errorMessage);
        }

        if ($input["confirmation"] == "yes") {
            // Check if User has any Cart
            $cart_exists = Cart::where("user_id", $id)->get();
            if (count($cart_exists) > 0) {
                $total_price = 0.0;
                $newOrder["order_code"] = $this->uniqueCodeGenerator();
                $newOrder["user_id"] = $cart_exists[0]->user_id;
                $newOrder["status"] = 1;
                for ($i = 0; $i < count($cart_exists); $i++) {
                    $PostProduct[$i]["product_id"] = $cart_exists[$i]["product_id"];
                    if ($cart_exists[$i]["product_quantity"] <= $cart_exists[$i]->product->stock) {
                        //delete from Wishlist
                        Wishlist::where("user_id", $id)->where("product_id",$cart_exists[$i]["product_id"])->delete();
                        $PostProduct[$i]["product_quantity"] = $cart_exists[$i]["product_quantity"];
                        $total_price = $total_price + ($cart_exists[$i]->product->price * $cart_exists[$i]["product_quantity"]);
                    } else {
                        return response()->json(["message" => 'The product ' . $cart_exists[$i]->product->name . ' does not have this much stock']);
                    }
                }
                $newOrder["total_price"] = $total_price;
                $PostOrder = Order::create($newOrder);

                if ($PostOrder) {
                    for ($i = 0; $i < count($cart_exists); $i++) {
                        $PostProduct[$i]["order_id"] = $PostOrder->id;
                        OrderhasProduct::create($PostProduct[$i]);
                    }
                    //delete the cart
                    app(UserController::class)->deleteCart($id);
                    return response()->json(["status" => $this->successStatus, "result" => $PostOrder]);
                } else {
                    return response()->json(["message" => 'Order not created due to an error']);
                }
            } else {
                return response()->json(["message" => 'No Cart found for this User']);
            }
        } else {
            return response()->json(["message" => 'Order not created']);
        }
    }

    protected function uniqueCodeGenerator()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersNo = strlen($characters);
        $codeLength = 6;

        $code = '';

        while (strlen($code) < $codeLength) {
            $position = rand(0, $charactersNo - 1);
            $character = $characters[$position];
            $code = $code . $character;
        }

        if (Order::where('order_code', $code)->exists()) {
            return $this->generateUniqueCode();
        }
        return $code;
    }
}
