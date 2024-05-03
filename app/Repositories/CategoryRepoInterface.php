<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Http\Request;
use DB;
use Config;

interface CategoryRepoInterface
{
    public function getAllCategories();
    public function getCateById(string $id);
    public function createCategory(array $data);
    public function updateCategory(array $data, string $id);
    public function deleteCategory(string $id);
    public function changStatus(array $data);
}