<?php

namespace Modules\Products\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Products\app\Models\Review;
use Illuminate\Support\Facades\Validator;


class ReviewController extends Controller
{
    public $successStatus = 200;
    //Create new Review
    public function createReview(Request $request)
    {
        $input = $request->validate([
            "description" => "required|min:3",
            "product_id" => "required|exists:products,id",
            "user_id" => "required|exists:users,id",
            "parent_id" => "exists:reviews,id"
        ]);
        
        $PostReview = Review::create($input);
        if ($PostReview) {
            return response()->json(["status" => $this->successStatus, "result" => $PostReview]);
        } else {
            return response()->json(["message" => 'Data not found']);
        }
    }

    //List all Reviews
    public function getAllReview()
    {
        $ReviewList = Review::all();
        return response()->json(["status" => $this->successStatus, 'results' => $ReviewList]);
    }

    //Review tree
    public function getReviewTree()
    {
        $ReviewTree = Review::where("parent_id", null)->with('child')->get();
        $Result = $this->getTree($ReviewTree);
        
        return response()->json(["status" => $this->successStatus, 'result' => $Result]);
    }

    //Recursive function of the Review tree
    protected function getTree($reviews)
    {
        $tree = [];
        foreach ($reviews as $review) 
        {
            $node = ['description' => $review->description];
            if ($review->child && sizeof($review->child)) {
                $node['replies'] = $this->getTree($review->child);
            }
            $tree[] = $node; 
        }
        return $tree;
    }

    //Get single Review, with Product info and username 
    public function getSingleReview($review_id)
    {
        $ReviewInfo = Review::with("user","product")->where("id",$review_id)->first();
        if ($ReviewInfo) {
            $Result['user_created_product'] = $ReviewInfo->product->user->name; 
            $Result['product_name'] = $ReviewInfo->product->name; 
            $Result['product_id'] = $ReviewInfo->product->id;
            $Result['product_category'] = $ReviewInfo->product->category->name;
            $Result['user_name_review'] = $ReviewInfo->user->name;
            $Result['review_description'] = $ReviewInfo->description;
            $Result['parent'] = $ReviewInfo->parent;
            $Result['child'] = $ReviewInfo->child;
            return response()->json(["status" => $this->successStatus, "result" => $Result]);
        } else {
            return response()->json(['message' => 'Data not found']);
        }
    }

    //Update single Review
    public function updateReview (Request $request, $id) {
        $getInput = $request->all();

        $validator = Validator::make($request->only("description", "product_id", "parent_id"), [
            "product_id" => "exists:products,id",
            "parent_id" => "exists:reviews,id"
        ]);

        if ($validator->fails()) {
            $errorMessage = response()->json($validator->errors()->all(), 400);
            return response()->json($errorMessage);
        }

        $ReviewUpdate = Review::find($id);
        $ReviewUpdate->description  = empty($getInput['description'])? $ReviewUpdate->description:$getInput['description'];
        $ReviewUpdate->product_id  = empty($getInput['product_id'])? $ReviewUpdate->product_id:$getInput['product_id'];
        $ReviewUpdate->parent_id  = empty($getInput['parent_id'])? $ReviewUpdate->parent_id:$getInput['parent_id'];
        
        if($ReviewUpdate->save()){
            return response()->json(["status"=>$this->successStatus,'result'=>$ReviewUpdate]);
        } 
        else {
            return response()->json(['message'=>'Data not found']);
        }
    }
}
