<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use phpDocumentor\Reflection\Types\Collection;

class Home extends Component
{
    public array $cards = [];

    public function mount()
    {
        $this->generateCards();
    }

    #[On('matchFound')]
    public function matchFound($indices)
    {
        foreach ($indices as $i) {
            unset($this->cards[$i]);
        }

        $this->cards = array_values($this->cards);
    }

    #[On('resetGame')]
    public function resetGame()
    {
        $this->generateCards();
    }

    private function generateCards(): void
    {
        $pairs = [];

        foreach (range(1, 32) as $num) {
            $pairs[] = [$num, $num];
        }

        $this->cards = collect($pairs)->flatten()->toArray();
        shuffle($this->cards);
    }

    public function render()
    {
        return view('livewire.home');
    }
}
