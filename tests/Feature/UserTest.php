<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\User;
use App\Models\Property;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Should a json with list of User
     * 
     * @return void
     */
    public function test_list_all_users()
    {
        $response = $this->get('/api/v1/users');
        
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data')
                    ->etc()
            );
    }

    /**
     * Test create a new user
     * 
     * @return void
     */
    public function test_create_new_user()
    {
        $data = [
            'name' => 'Someone Name',
            'email' => 'user@email.com',
        ];

        $response = $this->post('/api/v1/users', $data);
        
        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
        ]);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('name', $data['name'])
                    ->where('email', $data['email'])
                    ->etc()
            );
    }

    /**
     * Should return a user by id
     * 
     * @return void
     */
    public function test_find_user_by_id()
    {
        $user = User::factory()->create();

        $response = $this->get("/api/v1/users/{$user->id}");
        
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('name', $user->name)
                    ->where('email', $user->email)
                    ->etc()
        );
        
    }

    /**
     * Should update a user and change random user name and email
     * to "Updated Name Silva" and "updated@email.com"
     * 
     * @return void
     */
    public function test_update_user()
    {
        $user = User::factory()->create();

        $newData = [
            'name' => 'Updated Name Silva',
            'email' => 'updated@email.com',
        ];

        $response = $this->put("/api/v1/users/{$user->id}", $newData);

        $this->assertDatabaseHas('users', [
            'email' => $newData['email'],
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('name', $newData['name'])
                    ->where('email', $newData['email'])
                    ->etc()
            );
    }

    /**
     * Should delete a user by id
     * 
     * @return void
     */
    public function test_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->delete("/api/v1/users/{$user->id}");

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'email' => $user->email,
        ]);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * Should return all properties by userId
     * 
     * @return void
     */
    public function test_get_all_properties_by_userid()
    {
        $user = User::factory()
            ->has(Property::factory()->count(10))
            ->create();

        $response = $this->get("/api/v1/users/{$user->id}/properties");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('properties', 10)
                    ->etc()
            );
    }
}