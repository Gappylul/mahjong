<?php

namespace App\Livewire;

use Livewire\Component;
use phpDocumentor\Reflection\Types\Collection;

class Home extends Component
{
    public int $allPairs = 32;
    public array $cards = [];
    public array $selected = [];
    public bool $gamewon = false;

    public function mount()
    {
        $pairs = [];

        foreach (range(1, 32) as $num) {
            $pairs[] = [$num, $num];
        }

        $this->cards = collect($pairs)->flatten()->toArray();

        shuffle($this->cards);
    }

    public function selectCard(int $index)
    {
        if (in_array($index, $this->selected)) {
            $this->selected = array_filter($this->selected,
                fn($i) => $i !== $index);
            return;
        }

        $this->selected[] = $index;

        if (count($this->selected) === 2) {
            $first = $this->cards[$this->selected[0]];
            $second = $this->cards[$this->selected[1]];

            if ($first === $second) {
                foreach ($this->selected as $i) {
                    unset($this->cards[$i]);
                }
                $this->cards = array_values($this->cards);
                $this->allPairs -= 1;
                if ($this->allPairs === 0) {
                    $this->gamewon = true;
                }
            }
            $this->selected = [];
        }
    }

    public function render()
    {
        return view('livewire.home');
    }
}
