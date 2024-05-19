<?php

namespace App\Repositories\Interfaces;

interface SubCateRepoInterface
{
    public function getAllSubCategories();
    public function getSubCateById(string $id);
    public function createSubCategory(array $data);
    public function updateSubCategory(array $data, string $id);
    public function deleteSubCategory(string $id);
    public function changeStatus(array $data);
    public function getSubCategoriesByCategoryId(string $categoryId);
    public function getSubCategoriesByChildCategoryId(string $categoryId);
    public function countSubCategories($categoryId);
}
