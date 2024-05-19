<?php

namespace App\Repositories\Interfaces;

interface ChildCateRepoInterface
{
    // public function getAllChildCategories();
    public function getChildCateById(string $id);
    public function createChildCategory(array $data);
    public function updateChildCategory(array $data, string $id);
    public function deleteChildCategory(string $id);
    public function changeStatus(array $data);
    public function countChildCategories($categoryId);
}
