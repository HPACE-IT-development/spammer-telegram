<?php

namespace App\Livewire\N;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.n-app')]
class Bots extends Component
{
    public function render()
    {
        return view('livewire.n.bots');
    }
}
