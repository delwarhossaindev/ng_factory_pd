<?php

namespace App\Helpers;

use App\Models\Address;

trait Addressable
{
    /**
     * Summary of hasAddress
     * @return bool
     */
    public function hasAddress()
    {
        return (bool) $this->address()->count();
    }

    /**
     * Summary of addressable
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function addressable()
    {
        return $this->morphTo();
    }

    /**
     * Summary of address
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    /**
     * Summary of deleteAddress
     * @return mixed
     */
    public function deleteAddress()
    {
        return $this->addresses()->delete();
    }

    /**
     * Summary of saveAddress
     * @param mixed $request
     * @return \Illuminate\Database\Eloquent\Model|int
     */
    public function saveAddress($request)
    {
        if ($this->hasAddress()) {
            return $this->address()->update([
                'address_type' => $request->address_type,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'city' => $request->city,
                'zip_code' => $request->zip_code,
                'iso2' => $request->iso2,
                'phone' => $request->phone
            ]);
        }

        return $this->address()->create($request->all());
    }
}
