<?php
// app/Http/Controllers/RatingController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RatingService;
use App\Traits\ApiResponseTrait;

class RatingController extends Controller
{
    use ApiResponseTrait;

    protected $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $data['user_id'] = auth()->id(); // لو المستخدم مسجّل

        $rating = $this->ratingService->createRating($data);
        return $this->successResponse($rating, 'تم إضافة التقييم بنجاح');
    }

    public function show($menuItemId)
    {
        $ratings = $this->ratingService->getRatingsByMenuItem($menuItemId);
        $average = $this->ratingService->getAverageRating($menuItemId);

        return $this->successResponse([
            'average' => $average,
            'ratings' => $ratings
        ]);
    }
}
