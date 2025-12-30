<?php

namespace App\Http\Controllers\Api;

use App\Facades\Sqids;
use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\StoreExpenseRequest;
use App\Http\Requests\Expense\UpdateExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Services\ExpenseService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


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


    public function show(Request $request)
    {
        $encodedId = $request->query('id');

        if (!$encodedId) {
            return response()->json([
                'success' => false,
                'message' => 'ID parameter is required'
            ], 422);
        }

        try {
            $decodedId = Sqids::decode($encodedId);
        } catch (\InvalidArgumentException $e) {
            throw new NotFoundHttpException('Expense not found');
        }

        $expense = $this->expenseService->findById($decodedId);

        return new ExpenseResource($expense);
    }

    public function store(StoreExpenseRequest $request)
    {
        $expense = $this->expenseService->create(
            $request->validated()
        );

        return new ExpenseResource($expense);
    }

    public function update(string $id, UpdateExpenseRequest $request, ExpenseService $service)
    {
        $expense = $service->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Expense updated successfully.',
            'data' => Sqids::rec_encode_ids_in_list($expense),
        ]);
    }

    public function destroy(string $id)
    {
        try {
            $decodedId = Sqids::decode($id);
        } catch (\InvalidArgumentException) {
            throw new NotFoundHttpException('Expense not found');
        }

        $this->expenseService->deleteById($decodedId);

        return response()->json([
            'success' => true,
            'message' => 'Expense deleted successfully.'
        ]);
    }
}
