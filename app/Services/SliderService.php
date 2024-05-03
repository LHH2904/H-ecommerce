<?php

namespace App\Services;

use App\Repositories\SliderRepoInterface;
use Illuminate\Http\Request;

class SliderService
{
    public function __construct(
        protected SliderRepoInterface $sliderRepository
    ) {
    }

    public function all()
    {
        return $this->sliderRepository->getAllSliders();
    }

    public function find($id)
    {
        return $this->sliderRepository->getSliderById($id);
    }

    public function create(Request $request, array $data)
    {
        return $this->sliderRepository->createSlider($request, $data);
    }

    public function update(Request $request, array $data, $id)
    {
        return $this->sliderRepository->updateSlider($request, $data, $id);
    }

    public function delete($id)
    {
        return $this->sliderRepository->deleteSlider($id);
    }
}
