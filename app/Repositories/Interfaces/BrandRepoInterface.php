<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface BrandRepoInterface
{
    public function getAllBrands();
    public function getBrandById(string $id);
    public function createBrand(Request $request, array $data);
    public function updateBrand(Request $request, array $data, string $id);
    public function deleteBrand(string $id);
}
