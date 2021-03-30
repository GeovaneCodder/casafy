<?php

namespace Tests\Unit;

use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Testing\Fluent\AssertableJson;

class CreateUserTest extends TestCase
{
    /**
     * Test if name of user and email is required
     * 
     * @return void
     */
    public function test_should_user_name_and_email_is_required()
    {
        $data = [];

        $response = $this->post('/api/v1/users', $data, [
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('message')
                    ->has('errors', 2)
                    ->etc()
            );
    }
}
