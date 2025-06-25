<?php

namespace App\Repositories;

use App\Models\Favorite;

class FavoriteRepository
{
    public function add($userId, $menuItemId)
    {
        return Favorite::firstOrCreate([
            'user_id' => $userId,
            'menu_item_id' => $menuItemId,
        ]);
    }

    public function remove($userId, $menuItemId)
    {
        return Favorite::where('user_id', $userId)
                       ->where('menu_item_id', $menuItemId)
                       ->delete();
    }

    public function getByUser($userId)
    {
        return Favorite::with('menuItem')->where('user_id', $userId)->get();
    }
}
