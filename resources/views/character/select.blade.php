<x-default-layout>
    <x-slot:title>Choisissez votre personnage</x-slot>

    <div class="py-4">
        <h1 class="text-3xl font-black uppercase tracking-widest text-center text-white mb-1
                   drop-shadow-[0_2px_8px_rgba(220,38,38,0.7)]">
            Choisissez votre personnage
        </h1>
        <p class="text-center text-gray-400 text-sm uppercase tracking-widest mb-8">
            Sélectionnez votre combattant pour continuer
        </p>

        @if ($errors->any())
            <div class="mb-6 bg-red-900/60 border border-red-600 text-red-200 rounded-lg px-4 py-3 text-sm">
                {{ $errors->first('character_slug') }}
            </div>
        @endif

        <form id="character-form" method="POST" action="{{ route('character.store') }}">
            @csrf
            <input type="hidden" name="character_slug" id="character_slug_input" value="">

            @php
                $archetypeColors = [
                    'shoto'    => ['header' => 'text-blue-400 border-blue-800',   'card' => 'hover:border-blue-500',   'selected' => 'border-blue-500 bg-gray-800'],
                    'rushdown' => ['header' => 'text-red-400 border-red-800',     'card' => 'hover:border-red-500',    'selected' => 'border-red-500 bg-gray-800'],
                    'zoner'    => ['header' => 'text-purple-400 border-purple-800','card' => 'hover:border-purple-500','selected' => 'border-purple-500 bg-gray-800'],
                    'grappler' => ['header' => 'text-green-400 border-green-800', 'card' => 'hover:border-green-500',  'selected' => 'border-green-500 bg-gray-800'],
                    'unique'   => ['header' => 'text-amber-400 border-amber-800', 'card' => 'hover:border-amber-500',  'selected' => 'border-amber-500 bg-gray-800'],
                ];
                $grouped = collect($characters)->groupBy(fn($c) => $c->archetype->value);
            @endphp

            @foreach ($grouped as $archetype => $group)
                @php $colors = $archetypeColors[$archetype] ?? ['header' => 'text-gray-400 border-gray-700', 'card' => 'hover:border-gray-500', 'selected' => 'border-gray-500 bg-gray-800']; @endphp

                <div class="mb-8">
                    <h2 class="text-xs font-black uppercase tracking-widest mb-3 pb-2 border-b {{ $colors['header'] }}">
                        {{ $archetype }}
                    </h2>

                    <div class="grid grid-cols-6 gap-3">
                        @foreach ($group as $character)
                            <button
                                type="button"
                                data-slug="{{ $character->slug }}"
                                data-selected-class="{{ $colors['selected'] }}"
                                onclick="selectCharacter(this)"
                                class="character-card group relative flex flex-col items-center rounded-lg border-2 border-gray-700
                                       bg-gray-900 {{ $colors['card'] }} transition-all duration-150 cursor-pointer p-2
                                       focus:outline-none"
                            >
                                <div class="w-full aspect-square overflow-hidden rounded mb-2 bg-gray-800">
                                    <img
                                        src="{{ asset($character->profile_picture_path) }}"
                                        alt="{{ $character->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-150"
                                        onerror="this.src='/icons/profile.svg'"
                                    >
                                </div>

                                <span class="text-white font-bold text-xs text-center leading-tight">
                                    {{ $character->name }}
                                </span>

                                <div class="selected-indicator absolute inset-0 rounded-lg ring-2 ring-white/10 hidden pointer-events-none"></div>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="mt-8 flex justify-center">
                <button
                    type="submit"
                    id="submit-btn"
                    disabled
                    class="px-8 py-3 bg-red-700 text-white font-black uppercase tracking-widest rounded-lg
                           disabled:opacity-30 disabled:cursor-not-allowed hover:bg-red-600 transition-colors
                           text-sm shadow-lg shadow-red-900/50"
                >
                    Confirmer la sélection
                </button>
            </div>
        </form>
    </div>

    <script>
        function selectCharacter(card) {
            document.querySelectorAll('.character-card').forEach(function(c) {
                var prev = c.dataset.selectedClass.split(' ');
                c.classList.remove(...prev);
                c.classList.add('border-gray-700', 'bg-gray-900');
                c.querySelector('.selected-indicator').classList.add('hidden');
            });

            var selectedClasses = card.dataset.selectedClass.split(' ');
            card.classList.remove('border-gray-700', 'bg-gray-900');
            card.classList.add(...selectedClasses);
            card.querySelector('.selected-indicator').classList.remove('hidden');

            document.getElementById('character_slug_input').value = card.dataset.slug;
            document.getElementById('submit-btn').disabled = false;
        }
    </script>
</x-default-layout>
