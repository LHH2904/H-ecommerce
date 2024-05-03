<?php

namespace App\Repositories;

use App\Models\Slider;
use App\Repositories\SliderRepoInterface;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class SliderRepository implements SliderRepoInterface
{
    use ImageUploadTrait;
    public function getAllSliders()
    {
        return Slider::where('status', 1)->orderBy('serial', 'asc')->get();
    }

    public function getSliderById($id)
    {
        return Slider::findOrFail($id);
    }

    public function createSlider(Request $request, array $data)
    {
        $slider = new Slider();

        // Xử lý upload hình ảnh
        $imagePath = $this->uploadImage($request, 'banner', 'uploads'); // Đường dẫn tới hình ảnh

        // Gán các dữ liệu còn lại
        $slider->banner = $imagePath;
        $slider->type = $data['type'];
        $slider->title = $data['title'];
        $slider->starting_price = $data['starting_price'] ?? null;
        $slider->btn_url = $data['btn_url'] ?? null;
        $slider->serial = $data['serial'];
        $slider->status = $data['status'];

        $slider->save();
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
        $slider = Slider::findOrFail($id);

        $this->deleteImage($slider->banner);

        $slider->delete();
    }
}
