<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use App\Traits\ApiResponseTrait;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        return $this->successResponse($categories, 'تم جلب الاصناف بنجاح');
    }

    public function store(CategoryRequest $request)
    {
        $category = $this->categoryService->createCategory($request->validated());
        return $this->successResponse($category, 'تم إنشاءالصنف بنجاح', 201);
    }


    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = $this->categoryService->updateCategory($id, $request->validated());
            return $this->successResponse($category, 'تم تحديث الصنف بنجاح');
        } catch (\Exception $e) {
            return $this->errorResponse('تعذر تحديث الصنف', 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->categoryService->deleteCategory($id);
            return $this->successResponse(null, 'تم حذف الصنف بنجاح');
        } catch (\Exception $e) {
            return $this->errorResponse('تعذر الصنف القسم', 404);
        }
    }
}
