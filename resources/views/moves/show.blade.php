<x-default-layout>
    <x-slot:title>
        @if ($move->title)
            {{ __('ui.moves.show.title', [
                'move_title' => $move->title,
                'first_name' => $move->user->first_name,
                'last_name' => $move->user->last_name,
            ]) }}
        @else
            {{ __('ui.moves.show.title_without_move_title', [
                'first_name' => $move->user->first_name,
                'last_name' => $move->user->last_name,
            ]) }}
        @endif
    </x-slot>

    <x-slot:description>
        @if ($move->title)
            {{ __('ui.moves.show.description', [
                'move_title' => $move->title,
                'first_name' => $move->user->first_name,
                'last_name' => $move->user->last_name,
            ]) }}
        @else
            {{ __('ui.moves.show.description_without_move_title', [
                'first_name' => $move->user->first_name,
                'last_name' => $move->user->last_name,
            ]) }}
        @endif
    </x-slot>

    <article class="bg-white dark:bg-slate-800 rounded-lg shadow-md p-6">
        <header class="mb-6">
            @if ($move->title)
                <h1 class="text-3xl font-bold dark:text-white mb-2">
                    {{ $move->title }}
                </h1>
            @endif

            <p class="text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ url('@' . $move->user->username) }}">
                    {{ __('ui.moves.show.author', [
                        'first_name' => $move->user->first_name,
                        'last_name' => $move->user->last_name,
                    ]) }}
                </a>
                ·
                <span title="{{ $move->created_at->isoFormat('LLLL') }}">
                    {{ $move->created_at->diffForHumans() }}
                </span>
                @can('update', $move)
                    ·
                    <a href="{{ url('/moves/' . $move->id . '/edit') }}">
                        {{ __('ui.moves.edit.title_without_move_title') }}
                    </a>
                @endcan
            </p>
        </header>

        <div class="mb-4 space-y-2">
            @if ($move->strike)
                <p class="text-gray-700 dark:text-gray-300">
                    <span class="font-medium text-gray-500 dark:text-gray-400">Strike :</span>
                    {{ $move->strike->name }}
                </p>
            @endif
            @if ($move->character)
                <p class="text-gray-700 dark:text-gray-300">
                    <span class="font-medium text-gray-500 dark:text-gray-400">Personnage :</span>
                    {{ $move->character->name }}
                </p>
            @endif
        </div>

        <footer class="pt-4 border-t border-gray-200 dark:border-gray-700">
            @auth
                @php $isAuthor = $move->user_id === Auth::id(); @endphp

                @if (!$isAuthor && !$userVote)
                    <form method="POST" action="{{ route('moves.vote', $move) }}" class="mb-4">
                        @csrf
                        <div class="flex gap-3">
                            <button type="submit" name="type" value="buff"
                                class="px-6 py-2 bg-teal-600 dark:bg-teal-700 text-white font-semibold rounded-md hover:bg-teal-700 dark:hover:bg-teal-600 cursor-pointer">
                                ▲ Buff
                            </button>
                            <button type="submit" name="type" value="nerf"
                                class="px-6 py-2 bg-red-600 dark:bg-red-700 text-white font-semibold rounded-md hover:bg-red-700 dark:hover:bg-red-600 cursor-pointer">
                                ▼ Nerf
                            </button>
                        </div>
                    </form>
                @endif

                @if (session('success'))
                    <p class="mb-3 text-sm text-teal-600 dark:text-teal-400">{{ session('success') }}</p>
                @endif

                @if (session('error'))
                    <p class="mb-3 text-sm text-red-600 dark:text-red-400">{{ session('error') }}</p>
                @endif
            @endauth

            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                Score : {{ $move->score() }}
            </p>
        </footer>
    </article>
</x-default-layout>
