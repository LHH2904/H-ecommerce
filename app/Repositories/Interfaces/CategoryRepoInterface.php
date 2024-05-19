<?php

namespace App\Repositories\Interfaces;

interface CategoryRepoInterface
{
    public function getAllCategories();
    public function getCateById(string $id);
    public function createCategory(array $data);
    public function updateCategory(array $data, string $id);
    public function deleteCategory(string $id);
    public function changeStatus(array $data);
    
}