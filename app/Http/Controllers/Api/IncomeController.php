<?php

namespace App\Http\Controllers\Api;

use App\Facades\Sqids;
use App\Http\Controllers\Controller;
use App\Http\Requests\Income\StoreIncomeRequest;
use App\Http\Requests\Income\UpdateIncomeRequest;
use App\Http\Resources\IncomeResource;
use App\Services\IncomeService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IncomeController extends Controller
{
    public function __construct(
        protected IncomeService $incomeService
    ) {}

    public function index(Request $request)
    {
        if ($request->filled('id')) {
            $decodedId = Sqids::decode($request->query('id'));
            $income = $this->incomeService->findById($decodedId);
            return new IncomeResource($income);
        }

        return IncomeResource::collection(
            $this->incomeService->list()
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
            throw new NotFoundHttpException('Income not found');
        }

        $income = $this->incomeService->findById($decodedId);

        return new IncomeResource($income);
    }

    public function store(StoreIncomeRequest $request)
    {
        $income = $this->incomeService->create(
            $request->validated()
        );
        return new IncomeResource($income);
    }

    public function update(string $id, UpdateIncomeRequest $request, IncomeService $service)
    {
        $income = $service->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Income updated',
            'data' => Sqids::rec_encode_ids_in_list($income),
        ]);
    }

    public function destroy(string $id)
    {
        try {
            $decodedId = Sqids::decode($id);
        } catch (\InvalidArgumentException) {
            throw new NotFoundHttpException('Income not found');
        }

        $this->incomeService->deleteById($decodedId);

        return response()->json([
            'success' => true,
            'message' => 'Income deleted successfully.'
        ]);
    }
}
