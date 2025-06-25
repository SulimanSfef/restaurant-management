<?php
// app/Services/RatingService.php
namespace App\Services;

use App\Repositories\RatingRepository;

class RatingService
{
    protected $ratingRepository;

    public function __construct(RatingRepository $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
    }

    public function createRating($data)
    {
        return $this->ratingRepository->createRating($data);
    }

    public function getRatingsByMenuItem($menuItemId)
    {
        return $this->ratingRepository->getRatingsByMenuItem($menuItemId);
    }

    public function getAverageRating($menuItemId)
    {
        return $this->ratingRepository->getAverageRating($menuItemId);
    }
}
