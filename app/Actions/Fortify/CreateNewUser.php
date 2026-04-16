<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'password' => $this->passwordRules(),
        ])->validate();

        $role = session('onboarding_role', 'songwriter');

        $user = User::create([
            'name'             => $input['name'],
            'email'            => $input['email'],
            'password'         => Hash::make($input['password']),
            'role'             => $role,
            'status'           => 'pending',
            'onboarding_step'  => 3,
        ]);

        // Fortify fires the Registered event which sends the verification email
        // automatically — do not call sendEmailVerificationNotification() here
        // or the user will receive two emails.

        return $user;
    }
}
