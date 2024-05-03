<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepoInterface;
use App\Services\CateService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct(protected CateService $cateService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $categoryDataTable)
    {
        return $categoryDataTable->render('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'icon' => ['required', 'not_in:empty'],
            'name' => ['required', 'max:200', 'unique:categories,name'],
            'status' => ['required']
        ]);

        $this->cateService->create($data);

        toastr('Create Successfully!', 'success');
        return redirect()->route('admin.category.index');
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
        $category = $this->cateService->find($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'icon' => ['required', 'not_in:empty'],
            'name' => ['required', 'max:200', 'unique:categories,name,' . $id],
            'status' => ['required']
        ]);

        $this->cateService->update($data, $id);

        toastr('Update Successfully!', 'success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->cateService->delete($id);
        return response()->json(['status' => 'success', 'message' => 'Category deleted successfully.']);
    }

    public function changeStatus(Request $request)
    {
        $data = $request->all();
        $this->cateService->changeStatus($data);
        return response(['message' => 'Status has been updated!']);
    }
}
