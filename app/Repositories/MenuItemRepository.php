<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;
use App\Models\MenuItem;

class MenuItemRepository
{
    public function getAllMenuItems()
    {
        return MenuItem::all();
    }

  public function createMenuItem(array $data, $category_id)
{
    $data['category_id'] = $category_id;

    if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
        $data['image'] = $data['image']->store('menu_images', 'public');
    }

    return MenuItem::create($data);
}

    public function getMenuItemById($id)
    {
        return MenuItem::findOrFail($id);
    }

 public function updateMenuItem($id, array $data)
{
    $menuItem = MenuItem::findOrFail($id);

    if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
        if ($menuItem->image && Storage::disk('public')->exists($menuItem->image)) {
            Storage::disk('public')->delete($menuItem->image);
        }

        $data['image'] = $data['image']->store('menu_images', 'public');
    }

    $menuItem->update($data);
    return $menuItem;
}

    public function deleteMenuItem($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        return $menuItem->delete();
    }
}
