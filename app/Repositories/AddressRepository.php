<?php

namespace App\Repositories;

use App\Models\Address;

class AddressRepository
{
    public function create(array $data)
    {
        return Address::create($data);
    }

    public function getUserAddresses($userId)
    {
        return Address::where('user_id', $userId)->get();
    }

    // app/Repositories/AddressRepository.php

public function delete($id)
{
    return \App\Models\Address::findOrFail($id)->delete();
}

}

