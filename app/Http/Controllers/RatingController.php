<?php
// app/Http/Controllers/RatingController.php
namespace App\Http\Controllers;

use App\Services\RatingService;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\StoreRatingRequest;


class RatingController extends Controller
{
    use ApiResponseTrait;

    protected $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    public function store(StoreRatingRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $rating = $this->ratingService->storeRating($data);
        return $this->successResponse($rating, 'Rating saved');
    }

    public function show($menuItemId)
    {
        $ratings = $this->ratingService->getRatings($menuItemId);
        return $this->successResponse($ratings);
    }

    public function userRating($menuItemId)
    {
    $userId = auth()->id();
    $rating = $this->ratingService->getUserRatingForMenuItem($menuItemId, $userId);

    return $this->successResponse([
        'menu_item_id' => $menuItemId,
        'user_id' => $userId,
        'rating' => $rating
    ]);
    }


    public function average($menuItemId)
    {
        $average = $this->ratingService->getAverage($menuItemId);
        return $this->successResponse([
            'menu_item_id' => $menuItemId,
            'average_rating' => round($average, 1)
        ]);
    }
}


