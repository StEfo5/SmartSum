<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Новое меню') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Добавьте новое меню на день.") }}
        </p>
    </header>

    <form method="post" action="{{ route('menus.add') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="date" :value="__('Дата')" />
            <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('date')" />
        </div>

        <div>
            <x-input-label for="dormitory_breakfast" :value="__('Завтрак для учеников из Интерната')" />
            <x-text-input id="dormitory_breakfast" name="dormitory_breakfast" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('dormitory_breakfast')" />
        </div>

        <div>
            <x-input-label for="dormitory_dinner" :value="__('Обед для учеников из Интерната')" />
            <x-text-input id="dormitory_dinner" name="dormitory_dinner" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('dormitory_dinner')" />
        </div>

        <div>
            <x-input-label for="afternoon_snack" :value="__('Полдник для учеников из Интерната')" />
            <x-text-input id="afternoon_snack" name="afternoon_snack" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('afternoon_snack')" />
        </div>

        <div>
            <x-input-label for="supper" :value="__('Ужин для учеников из Интерната')" />
            <x-text-input id="supper" name="supper" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('supper')" />
        </div>

        <div>
            <x-input-label for="city_breakfast" :value="__('Завтрак для городских учеников')" />
            <x-text-input id="city_breakfast" name="city_breakfast" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('city_breakfast')" />
        </div>

        <div>
            <x-input-label for="entree" :value="__('Первое блюдо обеда для городских учеников')" />
            <x-text-input id="entree" name="entree" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('entree')" />
        </div>

        <div>
            <x-input-label for="second_course" :value="__('Второе блюдо обеда для городских учеников')" />
            <x-text-input id="second_course" name="second_course" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('second_course')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Сохранить') }}</x-primary-button>

            @if (session('status') === 'menu-added')
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
