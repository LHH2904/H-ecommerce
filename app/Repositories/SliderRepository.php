<?php

namespace App\Repositories;

use App\Models\Slider;
use App\Repositories\Interfaces\SliderRepoInterface;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class SliderRepository implements SliderRepoInterface
{
    use ImageUploadTrait;

    protected $model;

    public function __construct(Slider $model)
    {
        $this->model = $model;
    }


    public function getAllSliders()
    {
        return $this->model->where('status', 1)->orderBy('serial', 'asc')->get();
    }

    public function getSliderById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function createSlider(Request $request, array $data): Slider
    {
        // Xử lý upload hình ảnh
        $imagePath = $this->uploadImage($request, 'banner', 'uploads');

        // Tạo và lưu trữ slider mới
        $slider = $this->model::create([
            'banner' => $imagePath,
            'type' => $data['type'],
            'title' => $data['title'],
            'starting_price' => $data['starting_price'] ?? null,
            'btn_url' => $data['btn_url'] ?? null,
            'serial' => $data['serial'],
            'status' => $data['status'],
        ]);

        return $slider;
    }

    public function updateSlider(Request $request, array $data, string $id)
    {
        $slider = $this->getSliderById($id);

        // Handle file update
        $imagePath = $this->updateImage($request, 'banner', 'uploads', $slider->banner);

        // Gán các dữ liệu còn lại
        $slider->banner = empty(!$imagePath) ? $imagePath : $slider->banner;
        $slider->type = $data['type'];
        $slider->title = $data['title'];
        $slider->starting_price = $data['starting_price'] ?? null;
        $slider->btn_url = $data['btn_url'] ?? null;
        $slider->serial = $data['serial'];
        $slider->status = $data['status'];

        $slider->save();
    }

    public function deleteSlider($id)
    {
        $slider = $this->getSliderById($id);

        $this->deleteImage($slider->banner);

        $slider->delete();
    }
}
