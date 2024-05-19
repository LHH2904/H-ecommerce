<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Http\Requests\SliderUpdateRequest;
use App\Repositories\Interfaces\SliderRepoInterface;
use Illuminate\Http\Request;


class SliderController extends Controller
{
    private $sliderRepo;

    public function __construct(SliderRepoInterface $sliderRepo)
    {
        $this->sliderRepo = $sliderRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SliderDataTable $slideDataTable)
    {
        return $slideDataTable->render('admin.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderRequest  $request)
    {
        $data = $request->validated();

        $this->sliderRepo->createSlider($request, $data);

        // toastr()->success('Password updated successfully!');
        toastr('Create Successfully!', 'success');
        return redirect()->route('admin.slider.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slider =  $this->sliderRepo->getSliderById($id);
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        $this->sliderRepo->updateSlider($request, $data, $id);

        toastr('Update Successfully!', 'success');
        return redirect()->route('admin.slider.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->sliderRepo->deleteSlider($id);
        return response()->json(['status' => 'success', 'message' => 'Slider deleted successfully.']);
    }

    
}
