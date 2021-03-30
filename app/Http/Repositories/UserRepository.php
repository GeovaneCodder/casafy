<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends Repository
{
    /**
     * Set model for this repository
     * 
     * @var User
     */
    protected $model = User::class;

    /**
     * Find user by id and load all properties
     * 
     * @param int $id
     * @return Model
     */
    public function getPropertiesByUserid(int $id): Model
    {
        $user = $this->findById($id);
        $response = $user->load('properties');
        return $response;
    }
}