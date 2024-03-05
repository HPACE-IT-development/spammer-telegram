<?php

namespace App\Livewire\Forms;

use App\Models\Bot;
use App\Models\BotGroup;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Form;

class GroupForm extends Form
{
    public string $description = '';
    public string $name = '';

    public function createRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:32'],
            'description' => ['required', 'string', 'max:255'],
        ];
    }

//    public function updateRules()
//    {
//        return [
//            'name' => ['nullable', 'string', 'max:32'],
//            'description' => ['nullable', 'string', 'max:255'],
//        ];
//    }

    public function messages(): array
    {
        return [
            '*.required' => 'Обязательное поле.',
            '*.max' => 'Максимальное количество символов :max.',
            '*.string' => 'Неверный формат.',
        ];
    }

    public function store(): bool
    {
        $this->validate($this->createRules());

        $group = BotGroup::where('user_id', auth()->id())
            ->where('name', $this->name)
            ->first();

        if($group) {
            $this->addError(key: 'name', message: 'Группа с таким названием у Вас уже существует!');
            return false;
        }
        else {
            BotGroup::create([
                'user_id' => auth()->id(),
                'name' => $this->name,
                'description' => $this->description
            ]);
            $this->reset();
            return true;
        }
    }

    public function update()
    {

    }
}
