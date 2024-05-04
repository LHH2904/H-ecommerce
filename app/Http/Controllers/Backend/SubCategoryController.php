<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Services\CateService;
use App\Services\SubCateService;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function __construct(protected SubCateService $subCateService, protected CateService $cateService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SubCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.sub-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->cateService->all();
        return view('admin.sub-category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category' => ['required'],
            'name' => ['required', 'max:200', 'unique:sub_categories,name'],
            'status' => ['required']
        ]);
        $this->subCateService->create($data);

        toastr('Created Successfully!', 'success');
        return redirect()->route('admin.sub-category.index');
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
        $categories = $this->cateService->all();
        $subcategory = $this->subCateService->find($id);
        return view('admin.sub-category.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'category' => ['required'],
            'name' => ['required', 'max:200', 'unique:sub_categories,name,' . $id],
            'status' => ['required']
        ]);
        $this->subCateService->update($data, $id);

        toastr('Updated Successfully!', 'success');
        return redirect()->route('admin.sub-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->subCateService->delete($id);
        return response()->json(['status' => 'success', 'message' => 'Sub Category deleted successfully.']);
    }

    public function changeStatus(Request $request)
    {
        $data = $request->all();
        $this->subCateService->changeStatus($data);
        return response(['message' => 'Status has been updated!']);
    }
}