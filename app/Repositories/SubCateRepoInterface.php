<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Http\Request;
use DB;
use Config;

interface SubCateRepoInterface
{
    public function getAllSubCategories();
    public function getSubCateById(string $id);
    public function createSubCategory(array $data);
    public function updateSubCategory(array $data, string $id);
    public function deleteSubCategory(string $id);
    // public function changStatus(array $data);
}
