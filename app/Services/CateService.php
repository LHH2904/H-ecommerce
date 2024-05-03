<?php

namespace App\Services;

use App\Repositories\CategoryRepoInterface;

class CateService
{
    public function __construct(
        protected CategoryRepoInterface $cateRepository
    ) {
    }

    public function all()
    {
        return $this->cateRepository->getAllCategories();
    }

    public function find($id)
    {
        return $this->cateRepository->getCateById($id);
    }

    public function create(array $data)
    {
        return $this->cateRepository->createCategory($data);
    }

    public function update(array $data, $id)
    {
        return $this->cateRepository->updateCategory($data, $id);
    }

    public function delete($id)
    {
        return $this->cateRepository->deleteCategory($id);
    }

    public function changeStatus(array $data)
    {
        return $this->cateRepository->changStatus($data);
    }
}