<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Меню') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (Auth::user()->role==2)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('menus.partials.add-menu-form')
                    </div>
                </div>
            @endif
            
            @for ($i = 0; $i < count($menus); $i++)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __($dates[$i]['l']) }}
                            </h2>
                    
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __($dates[$i]['full']) }}
                            </p>
                        </header>
                        @if (Auth::user()->type==1)
                            <x-input-label class="mt-6 text-gray-900">
                                Завтрак: {{$menus[$i]->dormitory_breakfast}}
                            </x-input-label>
                            <x-input-label class="mt-1 text-gray-900">
                                Обед: {{$menus[$i]->dormitory_dinner}}
                            </x-input-label>
                            <x-input-label class="mt-1 text-gray-900">
                                Полдник: {{$menus[$i]->afternoon_snack}}
                            </x-input-label>
                            <x-input-label class="mt-1 text-gray-900">
                                Ужин: {{$menus[$i]->supper}}
                            </x-input-label>
                            <form action="{{route('menus.registration')}}" method="post" class="space-y-6">
                                @csrf
                                <select id="dormitory" name="dormitory" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"  required autofocus>
                                    <option value="0" @if ($dormitory[$i]==0)
                                        selected
                                    @endif>
                                        Не записываюсь
                                    </option>
                                    <option value="1" @if ($dormitory[$i]==1)
                                        selected
                                    @endif>
                                        Записываюсь
                                    </option>
                                </select>

                                <input type="" name="date" value="{{$menus[$i]->date}}" class="hidden">

                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Сохранить') }}</x-primary-button>
                        
                                    @if (session('status') === 'registration-updated')
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

                        @elseif(Auth::user()->type == 2)
                            
                            <form action="{{route('menus.registration')}}" method="post" class="space-y-6">
                                @csrf
                                <div>
                                    <x-input-label class="mt-6 text-gray-900">
                                        Завтрак: {{$menus[$i]->city_breakfast}}
                                    </x-input-label>
                                    <select id="breakfast" name="breakfast" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"  required autofocus>
                                        <option value="0" @if ($breakfast[$i]==0)
                                            selected
                                        @endif>
                                            Не записываюсь
                                        </option>
                                        <option value="1" @if ($breakfast[$i]==1)
                                            selected
                                        @endif>
                                            Записываюсь
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <x-input-label class="mt-1 text-gray-900">
                                        Первое: {{$menus[$i]->entree}}
                                    </x-input-label>
                                    <select id="entree" name="entree" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"  required autofocus>
                                        <option value="0" @if ($entree[$i]==0)
                                            selected
                                        @endif>
                                            Не записываюсь
                                        </option>
                                        <option value="1" @if ($entree[$i]==1)
                                            selected
                                        @endif>
                                            Записываюсь
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <x-input-label class="mt-1 text-gray-900">
                                        Второе: {{$menus[$i]->second_course}}
                                    </x-input-label>
                                    <select id="second_course" name="second_course" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"  required autofocus>
                                        <option value="0" @if ($second_course[$i]==0)
                                            selected
                                        @endif>
                                            Не записываюсь
                                        </option>
                                        <option value="1" @if ($second_course[$i]==1)
                                            selected
                                        @endif>
                                            Записываюсь
                                        </option>
                                    </select>
                                </div>
                                
                                <input type="" name="date" value="{{$menus[$i]->date}}" class="hidden">

                                <div class="flex items-center gap-4 mt-6">
                                    <x-primary-button>{{ __('Сохранить') }}</x-primary-button>
                        
                                    @if (session('status') === 'registration-updated')
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
                        @else
                            <x-input-label class="mt-6 text-gray-900">
                                Завтрак Интерната: {{$menus[$i]->dormitory_breakfast}}
                            </x-input-label>
                            <x-input-label class="mt-1 text-gray-900">
                                Обед Интерната: {{$menus[$i]->dormitory_dinner}}
                            </x-input-label>
                            <x-input-label class="mt-1 text-gray-900">
                                Полдник: {{$menus[$i]->afternoon_snack}}
                            </x-input-label>
                            <x-input-label class="mt-1 text-gray-900">
                                Ужин: {{$menus[$i]->supper}}
                            </x-input-label>
                            <x-input-label class="mt-6 text-gray-900">
                                Завтрак городских: {{$menus[$i]->city_breakfast}}
                            </x-input-label>
                            <x-input-label class="mt-1 text-gray-900">
                                Первое блюдо обеда городских: {{$menus[$i]->entree}}
                            </x-input-label>
                            <x-input-label class="mt-1 text-gray-900">
                                Второе блюдо обеда городских: {{$menus[$i]->second_course}}
                            </x-input-label>
                        @endif
                    </div>
                </div>
            @endfor
        </div>
    </div>
</x-app-layout>
