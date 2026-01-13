<?php

namespace App\Http\Controllers\Api;

use App\Facades\Sqids;
use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Expense;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $incomes = Income::where('user_id', $request->user()->id)->get()->map(function ($item) {
            return [
                'id' => Sqids::encode($item->id), // <-- encode id
                'date' => $item->date,
                'category' => $item->category,
                'amount' => $item->amount,
                'description' => $item->description,
                'type' => 'income'
            ];
        });

        $expenses = Expense::where('user_id', $request->user()->id)->get()->map(function ($item) {
            return [
                'id' => Sqids::encode($item->id), // <-- encode id
                'date' => $item->date,
                'category' => $item->category,
                'amount' => $item->amount,
                'description' => $item->description,
                'type' => 'expense'
            ];
        });

        $transactions = $incomes->merge($expenses)->sortByDesc('date')->values();

        return response()->json([
            'data' => $transactions
        ]);
    }
}
