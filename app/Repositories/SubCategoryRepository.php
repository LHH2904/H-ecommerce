<?php

namespace App\Repositories;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryRepository implements SubCateRepoInterface
{
    public function getAllSubCategories()
    {
        return SubCategory::all();
    }

    public function getSubCateById(string $id)
    {
        return SubCategory::findOrFail($id);
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
        $subcategory = SubCategory::findOrFail($id);
        $subcategory->delete();
    }

    public function changStatus($data)
    {
        $subcategory = SubCategory::findOrFail($data['id']);
        $subcategory->status = $data['status'] == 'true' ? 1 : 0;
        $subcategory->save();
    }
}
