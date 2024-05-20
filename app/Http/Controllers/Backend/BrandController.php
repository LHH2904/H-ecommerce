<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BrandDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\BrandRepoInterface;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    private $brandRepo;

    public function __construct(BrandRepoInterface $brandRepo)
    {
        $this->brandRepo = $brandRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(BrandDataTable $brandDataTable)
    {
        return $brandDataTable->render('admin.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'logo' => ['image', 'required', 'max:2048'],
            'name' => ['required', 'max:200'],
            'is_featured' => ['required'],
            'status' => ['required'],
        ]);

        $this->brandRepo->createBrand($request, $data);
        toastr('Create Successfully!', 'success');
        return redirect()->route('admin.brand.index');
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
        $brand =  $this->brandRepo->getBrandById($id);
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'logo' => ['image', 'max:2048'],
            'name' => ['required', 'max:200'],
            'is_featured' => ['required'],
            'status' => ['required'],
        ]);

        $this->brandRepo->updateBrand($request, $data, $id);

        toastr('Update Successfully!', 'success');
        return redirect()->route('admin.brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
