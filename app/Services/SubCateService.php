<?php

namespace App\Services;

use App\Repositories\SubCateRepoInterface;
use Illuminate\Http\Request;

class SubCateService
{
    public function __construct(
        protected SubCateRepoInterface $subCateRepo
    ) {
    }

    public function all()
    {
        return $this->subCateRepo->getAllSubCategories();
    }

    public function find($id)
    {
        return $this->subCateRepo->getSubCateById($id);
    }

    public function create(array $data)
    {
        return $this->subCateRepo->createSubCategory($data);
    }

    public function update(array $data, $id)
    {
        return $this->subCateRepo->updateSubCategory($data, $id);
    }

    public function delete($id)
    {
        return $this->subCateRepo->deleteSubCategory($id);
    }

    // public function changeStatus(array $data)
    // {
    //     return $this->cateRepository->changStatus($data);
    // }
}
