<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Carts\app\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Validator;
use Modules\Products\app\Models\Wishlist;

class UserController extends Controller
{
    public $successStatus = 200;

    //Login
    public function Login(Request $request){ 
        $data = $request->all();
        $validator = Validator::make($request->only('email', 'password'), [ 
            'email' => 'required', 
            'password' => 'required', 
        ]);
        if ($validator->fails()) {
            $errorMessage = response()->json($validator->errors()->all(), 400);
            return response()->json( $errorMessage);
        }
        $user=User::where('email',$data['email'])->first();
        
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
            if($user->role == '1' || $user->role == '2' || $user->role == '3'){
                // Token Creating
                $token = $user->createToken('Laravel Password')->plainTextToken;
                $response = [
                    'token' => 'Bearer '.$token
                ];
                return response()->json($response);
            }    
        }else{
            return response()->json(['message'=>'Data not found']);
        }
    }

    //Logout
    public function Logout () {
        Auth::logout();
        return response()->json(["status" => $this->successStatus, "message" => "Logged out successfully"]);
    }

    //Create new User
    public function createUser(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(),[
            "name" => 'required|min:3|unique:users',
            "email" => 'required|email',
            "password" => 'required|min:5'
        ]);

        if ($validator->fails()) {
            $errorMessage = response()->json($validator->errors()->all(), 400);
            return response()->json($errorMessage);
        } else {
            $input['password'] = Hash::make($input['password']);
            $UserList = User::all();
            //If first, make user SuperAdmin, otherwise User
            if ($UserList->isEmpty()) {
                $role = 1;
            } else {
                $role = 3;
            }
            $input['role'] = $role;
            $UserPost = User::create($input);
            if ($UserPost) {
                return response()->json(["status" => $this->successStatus, "result" => $UserPost]);
            } else {
                return response()->json(["message" => 'Data not found']);
            }
        }
    }

    //List all Users
    public function getAllUser()
    {
        $UserList = User::all();
        return response()->json(["status" => $this->successStatus, 'results' => $UserList]);
    }

    //Get single User
    public function getSingleUser($user_id)
    {
        $UserInfo = User::find($user_id);
        if ($UserInfo) {
            return response()->json(["status" => $this->successStatus, 'result' => $UserInfo]);
        } else {
            return response()->json(['message' => 'Data not found']);
        }
    }

    //Update single User, except role and balance
    public function updateUserDetails (Request $request, $id){
        $getInput = $request->all();
        $UserUpdate = User::find($id);
        $UserUpdate->name  = empty($getInput['name'])? $UserUpdate->name:$getInput['name'];
        $UserUpdate->email  = empty($getInput['email'])? $UserUpdate->email:$getInput['email'];
        $UserUpdate->password  = empty($getInput['password'])? $UserUpdate->password:$getInput['password'];
        if($UserUpdate->save()){
            return response()->json(["status"=>$this->successStatus,'result'=>$UserUpdate]);
        } 
        else {
            return response()->json(['message'=>'Data not found']);
        }
    }

    //Update role and balance of User
    public function updateUserCredentials (Request $request, $id){
        $getInput = $request->all();
        $validator = Validator::make($request->only("role", "balance"), [
            "role" => "exists:roles,id",
            "balance" => "numeric"
        ]);

        if ($validator->fails()) {
            $errorMessage = response()->json($validator->errors()->all(), 400);
            return response()->json( $errorMessage);
        }

        $UserCredentialsUpdate = User::find($id);
        $UserCredentialsUpdate->role = empty($getInput['role'])? $UserCredentialsUpdate->role:$getInput['role'];
        $UserCredentialsUpdate->balance = empty($getInput['balance'])? $UserCredentialsUpdate->balance:$getInput['balance'];
        if($UserCredentialsUpdate->save()){
            return response()->json(["status"=>$this->successStatus,'result'=>$UserCredentialsUpdate]);
        } 
        else {
            return response()->json(['message'=>'Data not found']);
        }
    }

    //Delete User
    public function deleteUser (Request $request, $id){
        $UserDelete = User::find($id);
        $UserDelete->delete();
    }

    //Show all orders by a single User
    // public function showUserOrders ($user_id) {
    //     $UserInfo = User::find($user_id);
    //     $PostInfo = User::find($user_id)->post()->where("user_id",$user_id)->get();
    //     if ($UserInfo && $PostInfo) {
    //         $Result['user_id'] = $UserInfo->id; 
    //         $Result['username'] = $UserInfo->name; 
    //         foreach ($PostInfo as $posts){
    //             $Result['posts'][$posts->id]['post_title'] = $posts->title;
    //             $Result['posts'][$posts->id]['post_description'] = $posts->description;
    //             $Result['posts'][$posts->id]['post_category'] = $posts->category->category_name;
    //         }
    //         return response()->json(["status" => $this->successStatus, 'result' => $Result]);
    //     } else {
    //         return response()->json(['message' => 'Data not found']);
    //     }

    // }

    //Show all Categories created by a single User
    public function showUserCategories ($user_id) {
        $CategoryInfo = User::with("category")->find($user_id);
        if ($CategoryInfo) {
            return response()->json(["status" => $this->successStatus, 'result' => $CategoryInfo]);
        } else {
            return response()->json(['message' => 'Data not found']);
        }
    }

    //Show all Products created by a single User
    public function showUserProducts ($user_id) {
        $ProductInfo = User::with("product")->find($user_id);
        if ($ProductInfo) {
            return response()->json(["status" => $this->successStatus, 'result' => $ProductInfo]);
        } else {
            return response()->json(['message' => 'Data not found']);
        }
    }

    //Clear Wishlist
    public function deleteWishlist($user_id)
    {
        $getWishlist = Wishlist::where("user_id", $user_id)->get();
        if (count($getWishlist) > 0) {
            for ($i = 0; $i < count($getWishlist); $i++) {
                $deleteProduct = Wishlist::find($getWishlist[$i]->id);
                $deleteProduct->delete();
            }
            return response()->json(["status" => $this->successStatus, 'message' => "Wishlist deleted successfully"]);
        } else {
            return response()->json(["status" => $this->successStatus, 'message' => "No Wishlist exists for this user"]);
        }
    }

    //Get Cart of a single user, with user_name and products
    public function getUserCart($user_id)
    {
        $CartInfo = User::with("cart")->where("id", $user_id)->first();
        if ($CartInfo->cart) { 
            $Result['user_name'] = $CartInfo->name; 
            $Result['user_id'] = $CartInfo->id; 
            foreach ($CartInfo->cart as $product_list){
                $Result['products'][$product_list->id]['id'] = $product_list->product->id;
                $Result['products'][$product_list->id]['name'] = $product_list->product->name;
                $Result['products'][$product_list->id]['quantity'] = $product_list->product_quantity;
                $Result['products'][$product_list->id]['unit'] = $product_list->product->unit;
            }
            return response()->json(["status" => $this->successStatus, 'result' => $Result]);
        } else {
            return response()->json(['message' => 'Data not found']);
        }
    }

    //Update quantity of products in a cart
    public function updateCartProductQuantity (Request $request, $id){
        $getInput = $request->all();
        $size = count($getInput["product_id"]);
        $validator = Validator::make($request->all(), [
            "product_id" => "required|array",
            "product_id.*" => ['distinct', 
                Rule::exists('carts', 'product_id')->where(function (Builder $query) use ($id) {
                return $query->where('user_id', intval($id));
            })],
            "product_quantity" => "required|array|size: $size",
            "product_quantity.*" => "numeric",
        ]);

        if ($validator->fails()) {
            $errorMessage = response()->json($validator->errors()->all(), 400);
            return response()->json($errorMessage);
        }
        
        $CartUpdate = User::with("cart")->where("id", $id)->first();
        for($i=0; $i<$size;$i++) {
            for($j=0;$j<count($CartUpdate->cart);$j++) {
                if ($getInput['product_id'][$i] == $CartUpdate->cart[$j]['product_id']){
                    $CartUpdate->cart[$j]['product_quantity'] = $getInput['product_quantity'][$i];
                }
            }
        }
        if($CartUpdate->save()){
            return response()->json(["status"=>$this->successStatus,'result'=>$CartUpdate]);
        } 
        else {
            return response()->json(['message'=>'Data not found']);
        }
    }

    //Delete products from a Cart
    public function deleteCartProduct (Request $request, $id){
        $getInput = $request->all();

        $validator = Validator::make($request->all(), [
            "product_id" => "required|array",
            "product_id.*" => ['distinct', 
            Rule::exists('carts', 'product_id')->where(function (Builder $query) use ($id) {
            return $query->where('user_id', intval($id));
        })]
        ]);

        if ($validator->fails()) {
            $errorMessage = response()->json($validator->errors()->all(), 400);
            return response()->json($errorMessage);
        }

        $CartUpdate = User::with("cart")->where("id", $id)->first();
        for($i=0; $i<count($getInput["product_id"]);$i++) {
            Cart::where("user_id", $id)->where("product_id", $getInput["product_id"][$i])->delete();        
        }
        
        return response()->json(["status"=>$this->successStatus,'result'=>$CartUpdate]);
    }

    //Delete a Cart
    public function deleteCart ($id) {
        $getCart = Cart::where("user_id", $id)->get();
        if(count($getCart) > 0) {
            for($i=0; $i<count($getCart); $i++) 
            {
                $deleteCartItems = Cart::find($getCart[$i]->id);
                $deleteCartItems->delete();
            }
            return response()->json(["status"=>$this->successStatus,'message'=> "Cart deleted successfully"]);
        } else {
            return response()->json(["status"=>$this->successStatus,'message'=> "No Cart exists for this user"]);
        }
    }

}
