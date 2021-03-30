<?php

namespace App\Http\Services;

use App\Http\Repositories\PropertyRepository;
use Carbon\Carbon;
use App\Models\Property;

class PropertyService
{
    /**
     * @var PropertyRepository
     */
    public $repository;

    /**
     * Where a create a new instance make a dependenci injection
     * 
     * @param PropertyRepository $repository
     * @return void
     */
    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage
     * 
     * @param array $data
     * @return Property
     */
    public function createProperty(array $data): Property
    {
        $ownerId = $data['owner_id'];
        $ownerProperties = $this->repository->countPropertiesByOwnerId($ownerId);

        if ($ownerProperties > 3) {
            throw new \Exception("The owner already has 3 unsold properties", 422);
        }

        return $this->repository->store($data);
    }

    /**
     * Display the specified resource
     * 
     * @param int $id
     * @return Property
     */
    public function getProperty(int $id): Property
    {
        $property = $this->repository->findById($id);
        
        //Check if is expired by created_at
        $property = $this->verifyPropertyExpired($property, 3);

        //Add discount to value
        $property = $this->calcPropertyDiscount($property);

        return $property;
    }

    /**
     * Checks if the property creation date and changes
     * it to expired according to the "$monthLimit" parameter
     * 
     * @param Property $property
     * @param int $monthLimit
     * @return Property
     */
    public function verifyPropertyExpired(Property $property, int $monthLimit = 3): Property
    {
        $date = Carbon::parse($property->created_at);

        if ($date->diffInMonths(Carbon::today()) >= $monthLimit && $property->expired == false) {
            $property = $this->repository->update($property->id, [
                'expired' => true,
            ]);
        }

        return $property;
    }

    /**
     * Calculates the percentage discount of the property
     * 
     * @param Property $property
     * @return Property
     */
    public function calcPropertyDiscount(Property $property): Property
    {
        $value = (int) $property->value;
        $discount = (int) $property->discount;

        if ($discount < 1 || $value < 1) {
            return $property;
        }

        $property->value = (($discount / 100) * $value);

        return $property;
    }
}