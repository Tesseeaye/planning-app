<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Boards') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="flex justify-end">
                    <x-link-button href="{{ route('web.board.create') }}">
                        Create Board
                    </x-link-button>
                </div>

                @if($boards)
                <div class="flex space-x-4">
                    @foreach($boards as $board)

                    <a href="{{ route('web.board.show', $board) }}">
                        <div class="bg-white rounded-md shadow-lg px-10 py-10 border border-gray-300">
                            {{ $board->name }}
                        </div>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
