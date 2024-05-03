<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\SliderService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // protected $sliderRepo;

    public function __construct(protected SliderService $sliderRepository)
    {
    }

    public function index()
    {
        $sliders = $this->sliderRepository->all();
        return view('frontend.home.home', compact('sliders'));
    }
}
