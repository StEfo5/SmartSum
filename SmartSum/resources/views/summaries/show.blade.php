<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Сводка '.$present_date) }}
        </h2>
    </x-slot>
    <div class="flex justify-between px-3 mt-2">
        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('summaries.show', ['date' => $previous_date]) }}">
            {{ __('Предыдущий день') }}
        </a>
        <a class=" underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('summaries.show', ['date' => $next_date]) }}">
            {{ __('Следующий день') }}
        </a>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (Auth::user()->role == 2)
            @foreach ($summaries as $summary)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __($classes[$summary->class_id]) }}
                            </h2>
                    
                            <p class="mt-1 text-sm text-gray-600">
                                @if ($summary->is_confirmed==0)
                                    Не подтвержденная
                                @else
                                    Подтвержденная
                                @endif
                                сводка питания класса {{$classes[$summary->class_id]}}
                            </p>
                        </header>

                        <div class="mt-6 space-y-6">
                            <div>
                                <p class="text-sm text-gray-600">
                                    Интернат: {{$summary->dormitory}}
                                </p>
                                <p class="text-sm text-gray-600">
                                    Городские: {{$summary->city}}
                                </p>
                                <p class="text-sm text-gray-600">
                                    Завтракают: {{$summary->breakfast}}
                                </p>
                                <p class="text-sm text-gray-600">
                                    Обедают: {{$summary->dinner}}
                                </p>
                                <p class="text-sm text-gray-600">
                                    Первое: {{$summary->entree}}
                                </p>
                                <p class="text-sm text-gray-600">
                                    Второе: {{$summary->second_course}}
                                </p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            @endforeach
            @else
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __($classes[$class_summary->class_id]) }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600">
                            @if ($class_summary->is_confirmed==0)
                                Не подтвержденная
                            @else
                                Подтвержденная
                            @endif
                            сводка питания класса {{$classes[$class_summary->class_id]}}
                        </p>
                    </header>

                    <form method="post" action="{{route('summary.confirm')}}" class="mt-6 space-y-6">
                        <div>
                            @csrf

                            <p class="text-sm text-gray-600">
                                Интернат: {{$class_summary->dormitory}}
                            </p>
                            <p class="text-sm text-gray-600">
                                Городские: {{$class_summary->city}}
                            </p>
                            <p class="text-sm text-gray-600">
                                Завтракают: {{$class_summary->breakfast}}
                            </p>
                            <p class="text-sm text-gray-600">
                                Обедают: {{$class_summary->dinner}}
                            </p>
                            <p class="text-sm text-gray-600">
                                Первое: {{$class_summary->entree}}
                            </p>
                            <p class="text-sm text-gray-600">
                                Второе: {{$class_summary->second_course}}
                            </p>
                        </div>

                        <input type="text" class="hidden" name="date" value="{{$date}}">

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Подтвердить') }}</x-primary-button>
                
                            @if (session('status') === 'summary-updated')
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
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Интернат') }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600">
                            Информация о питания каждого ученика Интерната из класса {{$classes[$class_summary->class_id]}}
                        </p>
                    </header>

                    <div class="mt-6 space-y-6">
                            @foreach ($dormitory_students as $student)
                            <div>
                                <x-input-label>@if ($student->is_confirmed)
                                    +
                                @else
                                    -
                                @endif{{$student->name}} @if ($student->is_registration)
                                    +
                                @else
                                    -
                                @endif</x-input-label>
                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Оповестить') }}</x-primary-button>
                        
                                    @if (session('status') === 'summary-updated')
                                        <p
                                            x-data="{ show: true }"
                                            x-show="show"
                                            x-transition
                                            x-init="setTimeout(() => show = false, 2000)"
                                            class="text-sm text-gray-600"
                                        >{{ __('Сообщение отправлено.') }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                    </div>
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Городские') }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600">
                            Информация о питания каждого гоородского ученика из класса {{$classes[$class_summary->class_id]}}
                        </p>
                    </header>

                    <div class="mt-6 space-y-6">
                            @foreach ($city_students as $student)
                            
                            <div>
                                <x-input-label>@if ($student->is_confirmed)
                                    +
                                @else
                                    -
                                @endif{{$student->name}}  @if ($student->breackfast)
                                    +
                                @else
                                    -
                                @endif @if ($student->entree)
                                    +
                                @else
                                    -
                                @endif @if ($student->second_course)
                                    +
                                @else
                                    -
                                @endif</x-input-label>
                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Оповестить') }}</x-primary-button>
                        
                                    @if (session('status') === 'summary-updated')
                                        <p
                                            x-data="{ show: true }"
                                            x-show="show"
                                            x-transition
                                            x-init="setTimeout(() => show = false, 2000)"
                                            class="text-sm text-gray-600"
                                        >{{ __('Сообщение отправлено.') }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
