<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Services\OfferService;
use App\Traits\ApiResponseTrait;

class OfferController extends Controller
{
    use ApiResponseTrait;

    protected $offerService;

    public function __construct()
    {
        $this->offerService = new OfferService();
    }

    public function index()
    {
        $offers = $this->offerService->getAllOffers();
        return $this->successResponse($offers, 'Offers retrieved successfully');
    }

    public function store(OfferRequest $request)
    {
        $offer = $this->offerService->createOffer($request->validated());
        return $this->successResponse($offer, 'Offer created successfully', 201);
    }

    public function show($id)
    {
        $offer = $this->offerService->getOfferById($id);
        if (!$offer) {
            return $this->errorResponse('Offer not found', 404);
        }
        return $this->successResponse($offer, 'Offer retrieved successfully');
    }

    public function update(OfferRequest $request, $id)
    {
        $offer = $this->offerService->updateOffer($id, $request->validated());
        if (!$offer) {
            return $this->errorResponse('Offer not found or not updated', 404);
        }
        return $this->successResponse($offer, 'Offer updated successfully');
    }

    public function destroy($id)
    {
        $deleted = $this->offerService->deleteOffer($id);
        if (!$deleted) {
            return $this->errorResponse('Offer not found', 404);
        }
        return $this->successResponse(null, 'Offer deleted successfully', 204);
    }
}
