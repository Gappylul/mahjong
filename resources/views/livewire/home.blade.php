<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div x-data="mahjongGame()" class="text-center">
        <div class="text-lg font-semibold mb-4">
            Cards left: <span x-text="cards.length"></span>
        </div>

        <div class="grid gap-4 transition-all duration-300"
             :class="'grid-cols-' + Math.min(8, Math.ceil(cards.length / 4))">
            <template x-for="(card, index) in cards" :key="index">
                <div
                    class="w-16 h-16 flex items-center justify-center border rounded cursor-pointer transition transform duration-300"
                    :class="selected.includes(index) ? 'bg-blue-400 scale-105' : 'bg-white'"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-0"
                    @click="toggleSelect(index)"
                >
                    <span x-text="card"></span>
                </div>
            </template>
        </div>

        <button @click="shuffle()" class="mt-6 px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-600">
            Shuffle
        </button>
    </div>
</div>

<script>
    function mahjongGame() {
        return {
            cards: @js($cards),
            selected: [],
            toggleSelect(index) {
                if (this.selected.includes(index)) {
                    this.selected = this.selected.filter(i => i !== index);
                } else {
                    this.selected.push(index);
                }

                if (this.selected.length === 2) {
                    const [first, second] = this.selected.map(i => this.cards[i]);

                    if (first === second) {
                        Livewire.dispatch('matchFound', { indices: this.selected });

                        setTimeout(() => {
                            this.selected.sort((a, b) => b - a).forEach(i => this.cards.splice(i, 1));

                            if (this.cards.length === 0) {
                                setTimeout(() => {
                                    if (confirm('🎉 You won! Play again?')) {
                                        this.shuffle();
                                        Livewire.dispatch('resetGame');
                                    }
                                }, 300);
                            }
                        }, 300);
                    }

                    setTimeout(() => this.selected = [], 300);
                }
            },
            shuffle() {
                this.cards = this.cards
                    .map(value => ({ value, sort: Math.random() }))
                    .sort((a, b) => a.sort - b.sort)
                    .map(({ value }) => value);

                this.selected = [];
            }
        }
    }
</script>
