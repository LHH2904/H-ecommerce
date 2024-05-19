<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CategoryRepoInterface;
use App\Repositories\Interfaces\ChildCateRepoInterface;
use App\Repositories\Interfaces\SubCateRepoInterface;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    private $subCateRepo;
    private $cateRepo;
    private $childCateRepo;

    public function __construct(SubCateRepoInterface $subCateRepo, CategoryRepoInterface $cateRepo, ChildCateRepoInterface $childCateRepo)
    {
        $this->subCateRepo = $subCateRepo;
        $this->cateRepo = $cateRepo;
        $this->childCateRepo = $childCateRepo;
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
        $categories = $this->cateRepo->getAllCategories();
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
        $this->subCateRepo->createSubCategory($data);

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
        $categories = $this->cateRepo->getAllCategories();
        $subcategory = $this->subCateRepo->getSubCateById($id);
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
        $this->subCateRepo->updateSubCategory($data, $id);

        toastr('Updated Successfully!', 'success');
        return redirect()->route('admin.sub-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subCategory = $this->subCateRepo->getSubCateById($id);
        $childCategory = $this->childCateRepo->countChildCategories($subCategory->id);
        if ($childCategory > 0) {
            return response()->json(['status' => 'error', 'message' => 'Vẫn còn danh mục con không thể xóa']);
        }

        $this->subCateRepo->deleteSubCategory($id);
        return response()->json(['status' => 'success', 'message' => 'Sub Category deleted successfully.']);
    }

    public function changeStatus(Request $request)
    {
        $data = $request->all();
        $this->subCateRepo->changeStatus($data);
        return response(['message' => 'Status has been updated!']);
    }
}
