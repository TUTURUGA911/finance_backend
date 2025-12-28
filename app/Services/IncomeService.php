<?php

namespace App\Services;

use App\Models\Income;
use App\Repositories\IncomeRepository;

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
        return $this->incomeRepository->create($data);
    }

    public function update(Income $income, array $data): Income
    {
        return $this->incomeRepository->update($income, $data);
    }

    public function delete(Income $income): void
    {
        $this->incomeRepository->delete($income);
    }
}
