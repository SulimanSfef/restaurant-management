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

    public function getAverageRating($menuItemId)
    {
        return Rating::where('menu_item_id', $menuItemId)->avg('rating');
    }
}

