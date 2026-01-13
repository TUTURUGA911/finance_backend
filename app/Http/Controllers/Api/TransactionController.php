<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Expense;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // Ambil incomes user
        $incomes = Income::where('user_id', $request->user()->id)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'date' => $item->date,
                'category' => $item->source, // normalize
                'amount' => $item->amount,
                'description' => $item->description,
                'type' => 'income'
            ];
        });

        // Ambil expenses user
        $expenses = Expense::where('user_id', $request->user()->id)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'date' => $item->date,
                'category' => $item->category, // sudah category
                'amount' => $item->amount,
                'description' => $item->description,
                'type' => 'expense'
            ];
        });

        // Gabungkan & sort berdasarkan date desc
        $transactions = $incomes->merge($expenses)->sortByDesc('date')->values();

        return response()->json([
            'data' => $transactions
        ]);
    }
}
