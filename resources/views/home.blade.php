<x-default-layout>
    <x-slot:title>
        {{ __('ui.home.title') }}
    </x-slot>

    <x-slot:description>
        {{ __('ui.home.description') }}
    </x-slot>

    <h1 class="text-2xl font-bold dark:text-white">
        {{ config('app.name') }}
    </h1>

    <p class="mt-4 dark:text-gray-300">
        {{ __('ui.home.introduction', ['app_name' => config('app.name')]) }}
    </p>

    <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8">
        {{ __('ui.home.recent_moves') }}
    </h2>

    <div class="mt-8 space-y-6">
        @foreach ($moves as $move)
            <x-move-card :move="$move" />
        @endforeach
    </div>

    <a href="{{ url('/moves') }}"
        class="mt-6 block w-full px-4 py-2 bg-teal-600 dark:bg-purple-900 text-white rounded-md hover:bg-teal-700 dark:hover:bg-purple-800 text-center">
        {{ __('ui.home.see_all_moves') }}
    </a>
</x-default-layout>
