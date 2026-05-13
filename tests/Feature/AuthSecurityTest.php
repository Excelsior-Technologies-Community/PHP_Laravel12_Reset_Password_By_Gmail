<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_requires_email_verification(): void
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'Sujal',
            'email' => 'sujal@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $response->assertRedirect(route('verification.notice'));
        $this->assertAuthenticated();
        Notification::assertSentTo(User::first(), VerifyEmail::class);
    }

    public function test_unverified_user_cannot_access_dashboard(): void
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertRedirect(route('verification.notice'));
    }

    public function test_verified_user_can_access_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Welcome, '.$user->name);
    }

    public function test_login_attempts_lock_account(): void
    {
        $user = User::factory()->create([
            'email' => 'locked@example.com',
            'password' => Hash::make('Password123'),
        ]);

        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => 'locked@example.com',
                'password' => 'wrong-password',
            ]);
        }

        $user->refresh();

        $this->assertSame(5, $user->failed_login_attempts);
        $this->assertTrue($user->locked_until->isFuture());

        $this->post('/login', [
            'email' => 'locked@example.com',
            'password' => 'Password123',
        ])->assertSessionHas('fail');

        $this->assertGuest();
    }

    public function test_profile_can_be_updated_with_current_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('Password123'),
        ]);

        $this->actingAs($user)
            ->put('/profile', [
                'name' => 'Updated Name',
                'email' => $user->email,
                'current_password' => 'Password123',
            ])
            ->assertSessionHas('success');

        $this->assertSame('Updated Name', $user->refresh()->name);
    }

    public function test_password_can_be_changed(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('Password123'),
        ]);

        $this->actingAs($user)
            ->put('/change-password', [
                'current_password' => 'Password123',
                'password' => 'NewPass123',
                'password_confirmation' => 'NewPass123',
            ])
            ->assertSessionHas('success');

        $this->assertTrue(Hash::check('NewPass123', $user->refresh()->password));
    }

    public function test_password_reset_link_is_throttled(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'reset@example.com',
        ]);

        $this->post('/forgot-password', ['email' => $user->email])
            ->assertSessionHas('success');

        $this->post('/forgot-password', ['email' => $user->email])
            ->assertSessionHas('fail');

        $this->assertSame(1, DB::table('password_resets')->where('email', $user->email)->count());
    }
}
