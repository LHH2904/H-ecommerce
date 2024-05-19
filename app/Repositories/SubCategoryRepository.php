<?php

namespace App\Repositories;

use App\Models\SubCategory;
use App\Repositories\Interfaces\SubCateRepoInterface;
use Illuminate\Support\Str;

class SubCategoryRepository implements SubCateRepoInterface
{
    protected $model;

    public function __construct(SubCategory $model)
    {
        $this->model = $model;
    }
    public function getAllSubCategories()
    {
        return $this->model->all();
    }

    public function getSubCateById(string $id)
    {
        return  $this->model->findOrFail($id);
    }

    public function createSubCategory(array $data)
    {
        $subcategory = new SubCategory();

        $subcategory->category_id = $data['category'];
        $subcategory->name = $data['name'];
        $subcategory->slug = Str::slug($data['name']);
        $subcategory->status = $data['status'];
        $subcategory->save();
    }

    public function updateSubCategory(array $data, string $id)
    {
        $subcategory = $this->getSubCateById($id);

        $subcategory->category_id = $data['category'];
        $subcategory->name = $data['name'];
        $subcategory->slug = Str::slug($data['name']);
        $subcategory->status = $data['status'];
        $subcategory->save();
    }

    public function deleteSubCategory($id)
    {
        $subcategory = $this->getSubCateById($id);
        $subcategory->delete();
    }

    public function changeStatus($data)
    {
        $subcategory = $this->model->findOrFail($data['id']);
        $subcategory->status = $data['status'] == 'true' ? 1 : 0;
        $subcategory->save();
    }

    public function getSubCategoriesByCategoryId($categoryId)
    {
        return $this->model->where('category_id', $categoryId)->where('status', 1)->get();
    }

    public function getSubCategoriesByChildCategoryId($categoryId)
    {
        return $this->model->where('category_id', $categoryId)->get();
    }

    public function countSubCategories($categoryId)
    {
        return $this->model->where('category_id', $categoryId)->count();
    }
}
