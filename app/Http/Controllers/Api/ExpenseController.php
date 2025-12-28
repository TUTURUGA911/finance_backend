<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\StoreExpenseRequest;
use App\Http\Requests\Expense\UpdateExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Services\ExpenseService;

class ExpenseController extends Controller
{
    public function __construct(
        protected ExpenseService $expenseService
    ) {}

    public function index()
    {
        return ExpenseResource::collection(
            $this->expenseService->list()
        );
    }

    public function store(StoreExpenseRequest $request)
    {
        $expense = $this->expenseService->create(
            $request->validated()
        );

        return new ExpenseResource($expense);
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $expense = $this->expenseService->update(
            $expense,
            $request->validated()
        );

        return new ExpenseResource($expense);
    }

    public function destroy(Expense $expense)
    {
        $this->expenseService->delete($expense);

        return response()->json([
            'success' => true,
            'message' => 'Expense deleted successfully.'
        ]);
    }
}
