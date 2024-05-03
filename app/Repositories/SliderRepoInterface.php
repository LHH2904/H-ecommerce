<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Http\Request;
use DB;
use Config;

interface SliderRepoInterface
{
    public function getAllSliders();
    public function getSliderById(string $id);
    public function createSlider(Request $request, array $data);
    public function updateSlider(Request $request, array $data, string $id);
    public function deleteSlider(string $id);
}
