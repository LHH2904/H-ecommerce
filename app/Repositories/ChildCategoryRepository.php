<?php

namespace App\Repositories;

use App\Models\ChildCategory;
use App\Models\SubCategory;
use App\Repositories\Interfaces\ChildCateRepoInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ChildCategoryRepository implements ChildCateRepoInterface
{
    protected $model;

    public function __construct(ChildCategory $model)
    {
        $this->model = $model;
    }
    public function getAllSubCategories()
    {
        return $this->model->all();
    }

    public function getChildCateById(string $id)
    {
        return  $this->model->findOrFail($id);
    }

    public function createChildCategory(array $data)
    {
        $childCategory = $this->model::create([
            'category_id' => $data['category'],
            'sub_category_id' => $data['sub_category'],
            'name' => $data['name'] ?? null,
            'slug' => Str::slug($data['name']),
            'status' => $data['status'],
        ]);
        return $childCategory;
    }

    public function updateChildCategory(array $data, string $id)
    {
        $childCategory = $this->getChildCateById($id);

        $childCategory->category_id = $data['category'];
        $childCategory->sub_category_id = $data['sub_category'];
        $childCategory->name = $data['name'];
        $childCategory->slug = Str::slug($data['name']);
        $childCategory->status = $data['status'];
        $childCategory->save();
    }

    public function deleteChildCategory($id)
    {
        $childCategory = $this->getChildCateById($id);
        $childCategory->delete();
    }

    public function changeStatus($data)
    {
        $childCategory = $this->model->findOrFail($data['id']);
        $childCategory->status = $data['status'] == 'true' ? 1 : 0;
        $childCategory->save();
    }

    public function countChildCategories($categoryId)
    {
        return $this->model->where('sub_category_id', $categoryId)->count();
    }
}