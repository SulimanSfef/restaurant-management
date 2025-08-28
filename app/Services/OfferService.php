<?php

namespace App\Services;

use App\Repositories\OfferRepository;
use Illuminate\Support\Facades\Storage;

class OfferService {
    protected $offerRepo;

    public function __construct() {
        $this->offerRepo = new OfferRepository();
    }

    public function createOffer(array $data) {
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('offers', 'public');
        }
        return $this->offerRepo->create($data);
    }

    public function updateOffer($id, array $data) {
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('offers', 'public');
        }
        return $this->offerRepo->update($id, $data);
    }

    public function getAllOffers() {
        return $this->offerRepo->getAll();
    }

    public function getOfferById($id) {
        return $this->offerRepo->getById($id);
    }

    public function deleteOffer($id) {
        return $this->offerRepo->delete($id);
    }


   public function getActiveOffers()
{
    return $this->offerRepo->getActiveOffers();
}
}
