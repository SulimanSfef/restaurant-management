<?php
// app/Services/RatingService.php
namespace App\Services;

use App\Repositories\RatingRepository;
use App\Models\Rating;
class RatingService
{
    protected $ratingRepository;
      protected $repository;

    public function __construct(RatingRepository $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
         $this->repository = new RatingRepository(); // بدون constructor injection

    }

    public function createRating($data)
    {
        return $this->ratingRepository->createRating($data);
    }

public function storeRating(array $data)
{
    return $this->ratingRepository->storeOrUpdate($data);
}

public function getRatings($menuItemId)
{
    return $this->ratingRepository->getByMenuItem($menuItemId);
}

public function getUserRatingForMenuItem($menuItemId, $userId)
{
    $rating = $this->ratingRepository->getUserRatingForMenuItem($menuItemId, $userId);
    return $rating ? $rating->rating : 0;
}

public function getAverage($menuItemId)
{
    return $this->ratingRepository->getAverageRating($menuItemId);
}


}



