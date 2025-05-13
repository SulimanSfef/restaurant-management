<?php

namespace App\Repositories;


use App\Models\MenuItem;

class MenuItemRepository
{
    public function getAllMenuItems()
    {
        return MenuItem::all();
    }

    public function createMenuItem(array $data,$category_id)
    {
        $data['category_id'] = $category_id;
        return MenuItem::create($data);
    }

    public function getMenuItemById($id)
    {
        return MenuItem::findOrFail($id);
    }

    public function updateMenuItem($id, array $data)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->update($data);
        $menuItem->save();
        return $menuItem;
    }

    public function deleteMenuItem($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        return $menuItem->delete();
    }
}
