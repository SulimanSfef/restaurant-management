<?php
namespace App\Services;

use App\Repositories\MenuItemRepository;

class MenuItemService
{
    protected $menuItemRepository;

    public function __construct(MenuItemRepository $menuItemRepository)
    {
        $this->menuItemRepository = $menuItemRepository;
    }

    public function getAllMenuItems()
    {
        return $this->menuItemRepository->getAllMenuItems();
    }

    public function createMenuItem($data,$category_id)
    {
        
        return $this->menuItemRepository->createMenuItem($data,$category_id);
    }

    public function getMenuItemById($id)
    {
        return $this->menuItemRepository->getMenuItemById($id);
    }

    public function updateMenuItem($id, $data)
    {

        return $this->menuItemRepository->updateMenuItem($id, $data);
    }

    public function deleteMenuItem($id)
    {
        return $this->menuItemRepository->deleteMenuItem($id);
    }
}

