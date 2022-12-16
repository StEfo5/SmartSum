<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Информация профиля') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Обновите информацию профиля вашей учетной записи и адрес электронной почты.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('ФИО')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Ваш адрес электронной почты не подтвержден.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="telegram_id" :value="__('Telegram ID')" />
            <x-text-input id="telegram_id" name="telegram_id" type="text" class="mt-1 block w-full" :value="old('telegram_id', $user->telegram_id)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('telegram_id')" />
        </div>

        <div>
            <x-input-label for="type" :value="__('Статус')" />
            <select id="type" name="type" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"  required autofocus>
                <option class="" disabled @if ($user->type == 0)
                    selected
                @endif>Выберите должность</option>
                <option value="1" @if ($user->type == 1)
                    selected
                @endif>Ученик из интерната</option>
                <option value="2" @if ($user->type == 2)
                    selected
                @endif>Ученик из города</option>
                <option value="3" @if ($user->type == 3)
                    selected
                @endif>Сотрудник РЛИ</option>
            </select>
        </div>

        <div>
            <x-input-label for="class_id" :value="__('Класс')" />
            <select name="class_id" id="class_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                <option disabled selected>Выберите класс</option>
                @foreach ($classes as $item)
                    <option @if ($user->class_id == $item->id)
                        selected
                    @endif value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('class_id')" />
        </div>
        
        <div>
            <x-input-label for="role" :value="__('Должность')" />
            <select name="role" id="role" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                <option value="0" @if ($user->role==0)
                    selected
                @endif> - </option>
                <option value="1" @if ($user->role==1)
                    selected
                @endif> Ответственный за сводку</option>
            </select>
        </div>

        

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Сохранить') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Сохранено.') }}</p>
            @endif
        </div>
    </form>
</section>
