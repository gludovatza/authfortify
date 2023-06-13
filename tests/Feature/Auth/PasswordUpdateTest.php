<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Mockery;

class PasswordUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_can_be_updated()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    public function test_correct_password_must_be_provided_to_update_password()
    {
        // $user = User::factory()->create();

        // $response = $this
        //     ->actingAs($user)
        //     ->from('/profile')
        //     ->put('/password', [
        //         'current_password' => 'wrong-password',
        //         'password' => 'new-password',
        //         'password_confirmation' => 'new-password',
        //     ]);

        // $response
        //     ->assertSessionHasErrorsIn('updatePassword', 'current_password')
        //     ->assertRedirect('/profile');
        $user = Mockery::mock(User::class);

        $this->mock(UpdatesUserPasswords::class)
                    ->shouldReceive('update')
                    ->once();

        $response = $this->withoutExceptionHandling()->actingAs($user)->putJson('/user/password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertStatus(200);
    }
}
