<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Repositories\Interfaces\CategoryRepoInterface;
use App\Repositories\Interfaces\SubCateRepoInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $cateRepo;
    private $subCateRepo;

    public function __construct(CategoryRepoInterface $cateRepo, SubCateRepoInterface $subCateRepo)
    {
        $this->cateRepo = $cateRepo;
        $this->subCateRepo = $subCateRepo;
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
    public function store(CategoryRequest $request)
    {
        $data = $request->validate();

        $this->cateRepo->createCategory($data);

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
        $category = $this->cateRepo->getCateById($id);
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

        $this->cateRepo->updateCategory($data, $id);

        toastr('Update Successfully!', 'success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->cateRepo->getCateById($id);
        $subCategory = $this->subCateRepo->countSubCategories($category->id);
        if ($subCategory > 0) {
            return response()->json(['status' => 'error', 'message' => 'Vẫn còn danh mục con không thể xóa']);
        }
        $this->cateRepo->deleteCategory($id);
        return response()->json(['status' => 'success', 'message' => 'Category deleted successfully.']);
    }

    public function changeStatus(Request $request)
    {
        $data = $request->all();
        $this->cateRepo->changeStatus($data);
        return response(['message' => 'Status has been updated!']);
    }
}
