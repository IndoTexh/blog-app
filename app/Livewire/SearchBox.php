<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

use function Laravel\Prompts\search;

class SearchBox extends Component
{
    public $search = '';
    public function update()
    {
        $this->dispatch('search', search : $this->search);
    }
    public function refresh()
    {
        $this->dispatch('refresh');
    }
    #[On('clear')]
    public function clear()
    {
        $this->search = '';
    }
    public function render()
    {
        return view('livewire.search-box');
    }
}
