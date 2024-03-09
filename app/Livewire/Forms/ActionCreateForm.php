<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ActionCreateForm extends Form
{
    public string $recipients = '';

    public string $text = '';

    public function rules(): array
    {
        return [
            'recipients' => ['required'],
            'text' => ['required', 'max:5']
        ];
    }

    public function messages(): array
    {
        return [
            'text.max' => 'Длина одного сообщения в личных чатах, группах и каналах — до 4096 символов.',
            '*.required' => 'Поле должно быть заполнено!'
        ];
    }

    public function store()
    {
        $this->validate();
    }
}
