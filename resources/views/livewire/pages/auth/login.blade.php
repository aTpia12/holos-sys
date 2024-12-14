<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');

form(LoginForm::class);

$login = function () {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();

    //$this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    $this->redirect(route('dashboard', absolute: false));
};

?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex">
        <div class="w-full">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('images/holo-logo-login.png') }}" alt="Logo" class="">
            </div>

            <form wire:submit="login">
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember" class="inline-flex items-center">
                        <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Recordar en este equipo') }}</span>
                    </label>
                </div>

                <div class="flex items-center text-center mt-4">
                    <x-primary-button class="ms-3">
                        {{ __('Ingresar') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
