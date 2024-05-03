<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\SliderRepoInterface;
use App\Services\SliderService;
use Illuminate\Http\Request;


class SliderController extends Controller
{
    // private $sliderRepo;

    public function __construct(protected SliderService $sliderService)
    {
        // $this->sliderRepo = $sliderRepo;
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'banner' => ['required', 'max:2048', 'image'],
            'type' => ['required', 'max:200'],
            'title' => ['required', 'max:200'],
            'starting_price' => ['max:200'],
            'btn_url' => ['url'],
            'serial' => ['required'],
            'status' => ['required']
        ]);

        $this->sliderService->create($request, $data);

        // toastr()->success('Password updated successfully!');
        toastr('Create Successfully!', 'success');
        return redirect()->route('admin.slider.index');
    }

    //     try {
    //         $this->sliderRepo->createSlider($request, $data);;
    //         toastr('Create Successfully!', 'success');
    //         return redirect()->back();
    //     } catch (\Exception $e) {
    //         // Xử lý lỗi khi không thể lưu trữ slider
    //         toastr('Failed to create slider!', 'error');
    //         return redirect()->back()->withInput();
    //     }
    // }

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
        $slider = $this->sliderService->find($id);
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'banner' => ['nullable', 'max:2048', 'image'],
            'type' => ['required', 'max:200'],
            'title' => ['required', 'max:200'],
            'starting_price' => ['max:200'],
            'btn_url' => ['url'],
            'serial' => ['required'],
            'status' => ['required']
        ]);

        $this->sliderService->update($request, $data, $id);

        toastr('Update Successfully!', 'success');
        return redirect()->route('admin.slider.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->sliderService->delete($id);
        return response()->json(['status' => 'success', 'message' => 'Slider deleted successfully.']);
    }
}
