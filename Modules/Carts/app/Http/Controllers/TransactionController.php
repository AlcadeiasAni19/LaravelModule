<?php

namespace Modules\Carts\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Carts\app\Models\Transaction;


class TransactionController extends Controller
{
    public $successStatus = 200;

    //Create new Transaction
    public function createTransaction(Request $request)
    {
        $input = $request->validate([
            "payment" => "required|numeric",
            "user_id" => "required|exists:users,id",
            "order_id" => "required|exists:orders,id"
        ]);
        
        $PostTransaction = Transaction::create($input);
        $PostTransaction->balance = ($PostTransaction->payment - $PostTransaction->order->total_price);
        $PostTransaction->order->user->balance = $PostTransaction->order->user->balance + $PostTransaction->balance;
        $PostTransaction->order->user->save();     
        if ($PostTransaction) {
            return response()->json(["status" => $this->successStatus, "result" => $PostTransaction]);
        } else {
            return response()->json(["message" => 'Data not found']);
        }
    }
}
