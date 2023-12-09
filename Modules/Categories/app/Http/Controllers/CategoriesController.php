<?php

namespace Modules\Categories\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Categories\app\Models\Category;

class CategoriesController extends Controller
{
    public $successStatus = 200;

    //Create new Category
    public function createCategory(Request $request)
    {
        $input = $request->validate([
            "name" => "required|min:3|unique:categories",
            "is_set" => "required|in:1,2",
            "user_id" => "required|exists:users,id",
        ]);

        $PostCategory = Category::create($input);
        if ($PostCategory) {
            return response()->json(["status" => $this->successStatus, "result" => $PostCategory]);
        } else {
            return response()->json(["message" => 'Data not found']);
        }
    }

    //List all Category, where is_set is true
    public function getAllCategory()
    {
        $CategoryList = Category::where("is_set",true)->get();
        return response()->json(["status" => $this->successStatus, 'results' => $CategoryList]);
    }

    //Get single Category
    public function getSingleCategory($category_id)
    {
        $CategoryInfo = Category::find($category_id);
        if ($CategoryInfo) {
            return response()->json(["status" => $this->successStatus, 'result' => $CategoryInfo]);
        } else {
            return response()->json(['message' => 'Data not found']);
        }
    }

    //Update single Category
    public function updateCategory (Request $request, $id){
        $getInput = $request->all();
        $validator = Validator::make($request->only("name", "is_set"), [
            "name" => "min:3| unique:categories",
            "is_set" => "in:1,2"
        ]);

        if ($validator->fails()) {
            $errorMessage = response()->json($validator->errors()->all(), 400);
            return response()->json( $errorMessage);
        }

        $CategoryUpdate = Category::find($id);

        if(isset($getInput['name'])){
            $CategoryUpdate->name = $getInput['name'];
        }

       if(isset($getInput['is_set'])){
        $CategoryUpdate->is_set = $getInput['is_set'];
        }
        
        if($CategoryUpdate->save()){
            return response()->json(["status"=>$this->successStatus,'result'=>$CategoryUpdate]);
        } 
        else {
            return response()->json(['message'=>'Data not found']);
        }
    }
}
