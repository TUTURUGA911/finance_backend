<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Income\StoreIncomeRequest;
use App\Http\Requests\Income\UpdateIncomeRequest;
use App\Http\Resources\IncomeResource;
use App\Models\Income;
use App\Services\IncomeService;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function __construct(
        protected IncomeService $incomeService
    ) {}

    public function index()
    {
        return IncomeResource::collection(
            $this->incomeService->list()
        );
    }

    public function store(StoreIncomeRequest $request)
    {
        $income = $this->incomeService->create(
            $request->validated()
        );
        return new IncomeResource($income);
    }

    public function update(UpdateIncomeRequest $request, Income $income)
    {
        return new IncomeResource(
            $this->incomeService->update($income, $request->validated())
        );
    }

    public function destroy(Income $income)
    {
        $this->incomeService->delete($income);

        return response()->json([
            'success' => true,
            'message' => 'Income deleted successfully.'
        ]);
    }
}
