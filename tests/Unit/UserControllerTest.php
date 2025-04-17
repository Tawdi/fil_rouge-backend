<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_updates_user_profile_successfully()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        
        $data = [
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
            'profile_image' => UploadedFile::fake()->image('profile.jpg')
        ];

        JWTAuth::shouldReceive('user')->once()->andReturn($user);

        $profileServiceMock = \Mockery::mock(ProfileService::class);
        $this->app->instance(ProfileService::class, $profileServiceMock);
        
        $profileServiceMock->shouldReceive('updateProfile')
            ->once()
            ->with($user, $data)
            ->andReturnUsing(function ($user, $data) { 
                $user->name = $data['name'];
                $user->email = $data['email'];
                return $user;
            });

        $response = $this->json('PUT', '/api/user/profile', $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Profile updated successfully',
                     'user' => [
                         'name' => 'Updated Name',
                         'email' => 'updatedemail@example.com',
                     ],
                 ]);
    }

    /** @test */
    public function it_handles_missing_profile_image_gracefully()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $data = [
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
        ];

        JWTAuth::shouldReceive('user')->once()->andReturn($user);

        $profileServiceMock = \Mockery::mock(ProfileService::class);
        $this->app->instance(ProfileService::class, $profileServiceMock);
        
        $profileServiceMock->shouldReceive('updateProfile')
            ->once()
            ->with($user, $data)
            ->andReturnUsing(function ($user, $data) {
                $user->name = $data['name'];
                $user->email = $data['email'];
                return $user;
            }); 

        $response = $this->json('PUT', '/api/user/profile', $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Profile updated successfully',
                     'user' => [
                         'name' => 'Updated Name',
                         'email' => 'updatedemail@example.com',
                     ],
                 ]);
    }
}
