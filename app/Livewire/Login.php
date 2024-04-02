<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.n-app')]
class Login extends Component
{
    #[Validate('required', message: 'Обзятаельное поле!')]
    public string $login = '';

    #[Validate('required', message: 'Обзятаельное поле!')]
    public string $password = '';

    public function save()
    {
        $this->validate();

        if(!Auth::attempt($this->only(['login', 'password']))) {
            $this->addError('login', 'Неверная пара логина и/или пароля!');
            return;
        }

        return $this->redirect('/bots');
    }

    public function render()
    {
        return view('livewire.login');
    }
}
