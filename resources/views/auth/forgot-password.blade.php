<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>

        {{-- CSSの読み込み --}}
        <link rel="stylesheet" href="css/forgot_password.css">
    </head>
    <body>

        <div class="forgot_password_container">
            {{-- <x-guest-layout> --}}
            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                {{ __('パスワードを忘れてしまった場合、以下にメールアドレスを記入してください。記入したメールアドレスにパスワードリセットのためのリンクをお送りしますので、新しいパスワードを決めてください。') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('パスワードリセットのリンクを送る') }}
                    </x-primary-button>
                </div>
            </form>
        {{-- </x-guest-layout> --}}
        </div>
    </body>
    </html>
