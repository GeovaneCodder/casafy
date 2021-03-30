<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Property;
use Tests\TestCase;
use App\Models\User;

class PropertyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Should a json with list of User
     * 
     * @return void
     */
    public function test_list_all_properties()
    {
        $response = $this->get('/api/v1/properties');
        
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data')
                    ->etc()
            );
    }

    /**
     * Test create a new property
     * 
     * @return void
     */
    public function test_create_new_property()
    {
        $user = User::factory()->create();

        $data = [
            "address" => "Rua Vergueiro, 126",
            "bedrooms" => 3,
            "bathrooms" => 2,
            "total_area" => 125,
            "purchased" => false,
            "value" => 125000,
            "discount" => 10,
            "owner_id" => $user->id,
            "expired" => false,
        ];

        $response = $this->post('/api/v1/properties', $data);
        
        $this->assertDatabaseHas('properties', [
            'address' => $data['address'],
        ]);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('address', $data['address'])
                    ->where('bedrooms', $data['bedrooms'])
                    ->where('bathrooms', $data['bathrooms'])
                    ->where('total_area', $data['total_area'])
                    ->where('purchased', $data['purchased'])
                    ->where('value', $data['value'])
                    ->where('discount', $data['discount'])
                    ->where('owner_id', $data['owner_id'])
                    ->where('expired', $data['expired'])
                    ->etc()
            );
    }

    /**
     * Should return a property by id
     * 
     * @return void
     */
    public function test_find_property_by_id()
    {
        $property = Property::factory()->create();

        $response = $this->get("/api/v1/properties/{$property->id}");
        
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('id', $property->id)
                    ->where('address', $property->address)
                    ->etc()
        );
    }

    /**
     * Should update a property and change address to
     * "Updated Address, 123"
     * 
     * @return void
     */
    public function test_update_property()
    {
        $property = Property::factory()->create();

        $newData = [
            'address' => 'Updated Address, 123',
        ];

        $response = $this->put("/api/v1/properties/{$property->id}", $newData);

        $this->assertDatabaseHas('properties', [
            'address' => $newData['address'],
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('address', $newData['address'])
                    ->etc()
            );
    }

    /**
     * Should delete a property by id
     * 
     * @return void
     */
    public function test_delete_property()
    {
        $property = Property::factory()->create();

        $response = $this->delete("/api/v1/properties/{$property->id}");

        $this->assertDatabaseMissing('properties', [
            'id' => $property->id,
            'address' => $property->address,
        ]);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
