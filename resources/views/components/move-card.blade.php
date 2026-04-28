<article class="bg-white dark:bg-slate-800 rounded-lg shadow-md p-6">
    <header class="mb-4">
        <div class="flex items-center gap-3 mb-3">
            <a href="{{ url('@' . $move->user->username) }}">
                <div
                    class="h-10 w-10 rounded-full bg-teal-600 dark:bg-purple-900 flex items-center justify-center text-white font-semibold hover:bg-teal-700 dark:hover:bg-purple-800">
                    {{ strtoupper(substr($move->user->first_name, 0, 1) . substr($move->user->last_name, 0, 1)) }}
                </div>
            </a>
            <div>
                <a href="{{ url('@' . $move->user->username) }}" class="hover:underline">
                    <p class="font-semibold text-gray-900 dark:text-white">
                        {{ $move->user->first_name }} {{ $move->user->last_name }}
                    </p>
                </a>
                <p class="text-sm text-gray-500 dark:text-gray-400" title="{{ $move->created_at->isoFormat('LLLL') }}">
                    {{ $move->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
        @if ($move->title)
            <a href="{{ url('/moves/' . $move->id) }}">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                    {{ $move->title }}
                </h2>
            </a>
        @endif
    </header>

    <div class="mb-4">
        <a href="{{ url('/moves/' . $move->id) }}">
            <p class="text-gray-700 dark:text-gray-300">
                {{ $move->content }}
            </p>
        </a>
    </div>

    <footer class="pt-4 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400">
            <span class="font-semibold text-gray-700 dark:text-gray-300">
                Score : {{ $move->score() }}
            </span>
            <a href="{{ url('/moves/' . $move->id) }}"
                class="px-4 py-2 bg-teal-600 dark:bg-purple-900 text-white rounded-md hover:bg-teal-700 dark:hover:bg-purple-800">
                {{ __('ui.moves.view_move') }}
            </a>
        </div>
    </footer>
</article>
