<div>
    <div class="flex flex-col justify-center items-center h-screen pb-16">
        @if(isset($this->cards))
            <div class="grid grid-cols-8 gap-4 p-4">
                @foreach($cards as $index => $card)
                    <div
                        class="w-16 h-16 flex items-center justify-center border rounded cursor-pointer
                    {{ in_array($index, $selected) ? 'bg-blue-400' : 'bg-white' }}"
                        wire:click="selectCard({{ $index }})"
                    >
                        {{ $card }}
                    </div>
                @endforeach
            </div>
            <p>All pairs {{ $this->allPairs }}</p>
        @else
            <p>You won!</p>
        @endif
    </div>
</div>
