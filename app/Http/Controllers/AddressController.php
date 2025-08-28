<?php
// app/Http/Controllers/AddressController.php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Services\AddressService;
use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class AddressController extends Controller
{
    use ApiResponseTrait;

    protected $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function store(StoreAddressRequest $request)
    {
        $address = $this->addressService->addAddress($request->validated());

        return $this->successResponse($address, 'تم إضافة الموقع بنجاح');
    }

    public function getByUser($userId)
    {
        $addresses = $this->addressService->getUserAddresses($userId);
        return $this->successResponse($addresses, 'تم جلب مواقع المستخدم بنجاح');
    }

public function destroy($id)
{
    try {
        $address = \App\Models\Address::findOrFail($id);

        if ($address->user_id !== auth()->id()) {
            return $this->errorResponse('You are not authorized to delete this address', 403);
        }

        $address->delete();
        return $this->successResponse(null, 'Address deleted successfully', 200);

    } catch (ModelNotFoundException $e) {
        return $this->errorResponse('Address not found', 404);
    } catch (\Exception $e) {
        return $this->errorResponse('Failed to delete address', 500, $e->getMessage());
    }
}



}

