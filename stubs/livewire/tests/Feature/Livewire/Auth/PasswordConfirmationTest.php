<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Livewire\Volt\Volt;

describe('PasswordConfirmation', function (): void {
    test('confirm password screen can be rendered', function (): void {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/confirm-password');

        $response
            ->assertSeeVolt('pages.auth.confirm-password')
            ->assertStatus(200);
    });

    test('password can be confirmed', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('pages.auth.confirm-password')
            ->set('password', 'password');

        $component->call('confirmPassword');

        $component
            ->assertRedirect('/account')
            ->assertHasNoErrors();
    });

    test('password is not confirmed with invalid password', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('pages.auth.confirm-password')
            ->set('password', 'wrong-password');

        $component->call('confirmPassword');

        $component
            ->assertNoRedirect()
            ->assertHasErrors('password');
    });
});
