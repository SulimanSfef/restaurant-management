<?php

// app/Repositories/RatingRepository.php
namespace App\Repositories;

use App\Models\Rating;

class RatingRepository
{
    public function createRating($data)
    {
        return Rating::create($data);
    }

    public function getRatingsByMenuItem($menuItemId)
    {
        return Rating::where('menu_item_id', $menuItemId)->with('user')->get();
    }

     public function storeOrUpdate(array $data)
    {
        return Rating::updateOrCreate(
            ['user_id' => $data['user_id'], 'menu_item_id' => $data['menu_item_id']],
            ['rating' => $data['rating']]
        );
    }

    public function getByMenuItem($menuItemId)
    {
        return Rating::where('menu_item_id', $menuItemId)->with('user')->get();
    }

    public function getUserRatingForMenuItem($menuItemId, $userId)
    {
        return Rating::where('menu_item_id', $menuItemId)
                    ->where('user_id', $userId)
                    ->first();
    }


    public function getAverageRating($menuItemId)
    {
        return Rating::where('menu_item_id', $menuItemId)->avg('rating');
    }
}




