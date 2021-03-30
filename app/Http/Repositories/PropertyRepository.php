<?php

namespace App\Http\Repositories;

use App\Models\Property;

class PropertyRepository extends Repository
{
    /**
     * Set model for this repository
     * 
     * @var User
     */
    protected $model = Property::class;

    /**
     * Count properties by ownerId
     * 
     * @param int $ownerId
     * @return int
     */
    public function countPropertiesNotPurchasedByOwnerId($ownerId): int
    {
        $query = $this->query();
        $query->where('owner_id', '=', $ownerId)
            ->where('purchased', '=', false);

        $response = $this->makeQuery($query, 0, false);

        return $response->count();
    }
}