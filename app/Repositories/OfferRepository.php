<?php

namespace App\Repositories;

use App\Models\Offer;
use Carbon\Carbon;

class OfferRepository {
    public function create(array $data) {
        return Offer::create($data);
    }

    public function getAll() {
        return Offer::with('menuItem')->get();
    }

    public function getById($id) {
        return Offer::with('menuItem')->findOrFail($id);
    }

    public function update($id, array $data) {
        $offer = Offer::findOrFail($id);
        $offer->update($data);
        return $offer;
    }

    public function delete($id) {
        return Offer::destroy($id);
    }

     public function getActiveOffers()
    {
        $today = Carbon::today();
        return Offer::where('is_active', true)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->get();
    }
}
