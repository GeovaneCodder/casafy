<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\User;
use App\Models\Property;

class CreatePropertyTest extends TestCase
{
    /**
     * Test if validation fields work
     *
     * @return void
     */
    public function test_required_fields()
    {
        $data = [];

        $response = $this->post('/api/v1/properties', $data, [
            'content-type' => 'application/json',
            'accept' => 'application/json',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('message')
                    ->has('errors', 9)
                    ->etc()
            );
    }

    public function test_expect_error_when_the_owner_has_more_than_three_unsold_properties()
    {
        $user = User::factory()
            ->has(Property::factory()->count(4))
            ->create();

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

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('success', false)
                    ->has('message')
                    ->etc()
            );
    }
}
