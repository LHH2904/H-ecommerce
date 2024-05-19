<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface SliderRepoInterface
{
    public function getAllSliders();
    public function getSliderById(string $id);
    public function createSlider(Request $request, array $data);
    public function updateSlider(Request $request, array $data, string $id);
    public function deleteSlider(string $id);
}