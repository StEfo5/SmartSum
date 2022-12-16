<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Информация профиля РЛИ') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Обновите информацию профиля РЛИ вашей учетной записи.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.rli_update') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="type" :value="__('Статус')" />
            <select id="type" name="type" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"  required autofocus>
                <option disabled @if ($user->type == 0)
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

        @if ($user->type!=0 && $user->type<3)
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
        @endif
        
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
