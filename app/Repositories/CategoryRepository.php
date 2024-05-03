<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\CategoryRepoInterface;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryRepoInterface
{
    public function getAllCategories()
    {
        return Category::all();
    }

    public function getCateById($id)
    {
        return Category::findOrFail($id);
    }

    public function createCategory(array $data)
    {
        $category = new Category();
        $category->icon = $data['icon'];
        $category->name = $data['name'];
        $category->slug = Str::slug($data['name']);
        $category->status = $data['status'];
        $category->save();
    }

    public function updateCategory(array $data, string $id)
    {
        $category = $this->getCateById($id);
        $category->icon = $data['icon'];
        $category->name = $data['name'];
        $category->slug = Str::slug($data['name']);
        $category->status = $data['status'];
        $category->save();
    }

    public function deleteCategory($id)
    {
        $category = $this->getCateById($id);
        $category->delete();
    }

    public function changStatus(array $data)
    {
        $category = $this->getCateById($data['id']);
        $category->status = $data['status'] == 'true' ? 1 : 0;
        $category->save();
    }
}
