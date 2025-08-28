<?php

namespace App\Services;

use App\Repositories\AddressRepository;

class AddressService
{
    protected $addressRepo;

    public function __construct(AddressRepository $addressRepo)
    {
        $this->addressRepo = $addressRepo;
    }

    public function addAddress($data)
    {
        return $this->addressRepo->create($data);
    }

    public function getUserAddresses($userId)
    {
        return $this->addressRepo->getUserAddresses($userId);
    }

    // app/Services/AddressService.php

public function deleteAddress($id)
{
    return $this->addressRepo->delete($id);
}

}

