<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuItemRequest;
use App\Http\Requests\MenuItemUpdateRequest;
use App\Services\MenuItemService;
use App\Traits\ApiResponseTrait;

class MenuItemController extends Controller
{
    use ApiResponseTrait;

    protected $menuItemService;

    public function __construct(MenuItemService $menuItemService)
    {
        $this->menuItemService = $menuItemService;
    }

    public function index()
    {
        $menuItems = $this->menuItemService->getAllMenuItems();
        return $this->successResponse($menuItems, 'تم جلب عناصر القائمة بنجاح');
    }

    public function store(MenuItemRequest $request, $category_id)
    {
        try {
            $menuItem = $this->menuItemService->createMenuItem($request->validated(), $category_id);
            return $this->successResponse($menuItem, 'تم إنشاء عنصر القائمة بنجاح', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('حدث خطأ أثناء إنشاء العنصر', 500, $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $menuItem = $this->menuItemService->getMenuItemById($id);
            return $this->successResponse($menuItem, 'تم جلب عنصر القائمة بنجاح');
        } catch (\Exception $e) {
            return $this->errorResponse('العنصر غير موجود', 404);
        }
    }

    public function update(MenuItemUpdateRequest $request, $id)
    {
        try {
            $menuItem = $this->menuItemService->updateMenuItem($id, $request->validated());
            return $this->successResponse($menuItem, 'تم تحديث عنصر القائمة بنجاح');
        } catch (\Exception $e) {
            return $this->errorResponse('تعذر تحديث العنصر', 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->menuItemService->deleteMenuItem($id);
            return $this->successResponse(null, 'تم حذف عنصر القائمة بنجاح');
        } catch (\Exception $e) {
            return $this->errorResponse('تعذر حذف العنصر', 404);
        }
    }
}
