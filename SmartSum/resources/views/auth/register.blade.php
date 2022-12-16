<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('ФИО')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Telegram ID -->
            <div class="mt-4">
                <x-input-label for="telegram_id" :value="__('Telegram ID (получите от бота @getmyid_bot)')" />
                <x-text-input id="telegram_id" class="block mt-1 w-full" type="text" name="telegram_id" :value="old('telegram_id')" required />
                <x-input-error :messages="$errors->get('telegram_id')" class="mt-2" />
            </div>
            
            <!-- Status -->
            <div class="mt-4">
                <x-input-label for="type" :value="__('Статус')" />
                <select id="type" name="type" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"  required autofocus>
                    <option class="" disabled selected>Выберите статус</option>
                    <option value="1" >Ученик из интерната</option>
                    <option value="2" >Ученик из города</option>
                    <option value="3" >Сотрудник РЛИ</option>
                </select>
                <x-input-error :messages="$errors->get('type')" class="mt-2" />
            </div>

            <!-- Class -->
            <div class="mt-4">
                <x-input-label for="class_id" :value="__('Класс (если вы сотрудник РЛИ, выберите любой)')" />
                <select name="class_id" id="class_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                    <option disabled selected>Выберите класс</option>
                    @foreach ($classes as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('class_id')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Пароль')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Подтвердите пароль')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Уже зарегистрировались?') }}
                </a>

                <x-primary-button class="ml-4">
                    {{ __('Зарегистрироваться') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
