<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\Interfaces\BrandRepoInterface;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandRepository implements BrandRepoInterface
{
    use ImageUploadTrait;

    protected $model;

    public function __construct(Brand $model)
    {
        $this->model = $model;
    }


    public function getAllBrands()
    {
        return $this->model->where('status', 1)->orderBy('serial', 'asc')->get();
    }

    public function getBrandById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function createBrand(Request $request, array $data)
    {
        // Xử lý upload hình ảnh
        $logoPath = $this->uploadImage($request, 'logo', 'uploads');

        // Tạo và lưu trữ brand mới
        $brand = $this->model::create([
            'logo' => $logoPath,
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'is_featured' => $data['is_featured'],
            'status' => $data['status'],
        ]);

        return $brand;
    }

    public function updateBrand(Request $request, array $data, string $id)
    {
        $brand = $this->getBrandById($id);

        // Handle file update
        $logoPath = $this->updateImage($request, 'logo', 'uploads', $brand->logoPath);

        // Gán các dữ liệu còn lại
        $brand->logo = empty(!$logoPath) ? $logoPath : $brand->logo;
        $brand->name = $data['name'];
        $brand->slug = Str::slug($data['name']);
        $brand->is_featured = $data['is_featured'];
        $brand->status = $data['status'];

        $brand->save();
    }

    public function deleteBrand($id)
    {
        $slider = $this->getBrandById($id);

        $this->deleteImage($slider->banner);

        $slider->delete();
    }
}
