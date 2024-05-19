<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ChildCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChildCategoryRequest;
use App\Models\SubCategory;
use App\Repositories\Interfaces\CategoryRepoInterface;
use App\Repositories\Interfaces\ChildCateRepoInterface;
use App\Repositories\Interfaces\SubCateRepoInterface;
use Illuminate\Http\Request;

class ChildCategoryController extends Controller
{
    private $subCateRepo;
    private $cateRepo;
    private $childCateRepo;

    public function __construct(
        SubCateRepoInterface $subCateRepo,
        CategoryRepoInterface $cateRepo,
        ChildCateRepoInterface $childCateRepo
    ) {
        $this->subCateRepo = $subCateRepo;
        $this->cateRepo = $cateRepo;
        $this->childCateRepo = $childCateRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ChildCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.child-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->cateRepo->getAllCategories();
        $subCategories = $this->subCateRepo->getAllSubCategories();
        return view('admin.child-category.create', compact('categories', 'subCategories'));
    }

    /**
     * Get Sub Categories.
     */
    public function getSubCategories(Request $request)
    {
        $subCategories = $this->subCateRepo->getSubCategoriesByCategoryId($request->id);
        return $subCategories;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChildCategoryRequest $request)
    {
        $data = $request->validated();

        $this->childCateRepo->createChildCategory($data);
        toastr('Created Successfully!', 'success');
        return redirect()->route('admin.child-category.index');
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
        $childCategory = $this->childCateRepo->getChildCateById($id);
        $subCategories = $this->subCateRepo->getSubCategoriesByChildCategoryId($childCategory->category_id);
        return view('admin.child-category.edit', compact('childCategory', 'categories', 'subCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data = $request->validate([
            'category' => ['required'],
            'sub_category' => ['required'],
            'name' => ['required', 'max:200', 'unique:child_categories,name,' . $id],
            'status' => ['required']
        ]);
        $this->childCateRepo->updateChildCategory($data, $id);

        toastr('Updated Successfully!', 'success');
        return redirect()->route('admin.child-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->childCateRepo->deleteChildCategory($id);
        return response()->json(['status' => 'success', 'message' => 'Child Category deleted successfully.']);
    }

    public function changeStatus(Request $request)
    {
        $data = $request->all();
        $this->childCateRepo->changeStatus($data);
        return response(['message' => 'Status has been updated!']);
    }
}