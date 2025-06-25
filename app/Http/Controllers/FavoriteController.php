<?php

// app/Http/Controllers/FavoriteController.php

namespace App\Http\Controllers;

use App\Services\FavoriteService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    use ApiResponseTrait;

    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function store($menu_item_id)
    {

        $favorite = $this->favoriteService->addFavorite(auth()->id(), $menu_item_id);

        return $this->successResponse($favorite, 'تمت الإضافة إلى المفضلة');
    }

    public function destroy($menuItemId)
    {
        $this->favoriteService->removeFavorite(auth()->id(), $menuItemId);

        return $this->successResponse(null, 'تمت الإزالة من المفضلة');
    }

    public function index()
    {
        $favorites = $this->favoriteService->getUserFavorites(auth()->user()->id);

        return $this->successResponse($favorites, 'قائمة المفضلة');
    }
}
