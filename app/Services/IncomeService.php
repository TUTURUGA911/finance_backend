<?php

namespace App\Services;

use App\Facades\Sqids;
use App\Models\Income;
use App\Repositories\IncomeRepository;
use Illuminate\Support\Facades\Auth;

class IncomeService
{
    public function __construct(
        protected IncomeRepository $incomeRepository
    ) {}

    public function list()
    {
        return $this->incomeRepository->all();
    }

    public function create(array $data): Income
    {
        $data['user_id'] = Auth::id();
        return $this->incomeRepository->create($data);
    }


    public function update(string $encodedId, array $data): Income
    {
        $id = Sqids::decode($encodedId);

        return $this->incomeRepository->update($id, $data);
    }

    public function findById(int $id): Income
    {
        return $this->incomeRepository->find($id);
    }

    public function deleteById(int $id): void
    {
        $this->incomeRepository->delete($id);
    }


    public function delete(string $encodedId): void
    {
        $id = Sqids::decode($encodedId);

        $this->incomeRepository->delete($id);
    }
}
