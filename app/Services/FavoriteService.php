<?php

namespace App\Services;

use App\Repositories\FavoriteRepository;

class FavoriteService
{
    protected $favoriteRepository;

    public function __construct(FavoriteRepository $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function addFavorite($userId, $menuItemId)
    {
        return $this->favoriteRepository->add($userId, $menuItemId);
    }

    public function removeFavorite($userId, $menuItemId)
    {
        return $this->favoriteRepository->remove($userId, $menuItemId);
    }

    public function getUserFavorites($userId)
    {
        return $this->favoriteRepository->getByUser($userId);
    }
}
