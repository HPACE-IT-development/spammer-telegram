<?php

namespace App\Livewire\Forms;

use App\Models\Action;
use App\Rules\RecipientsList;
use Illuminate\Support\Facades\Log;
use Livewire\Form;

class ActionCreateNewsletterForm extends Form
{
    public string $recipients = '';

    public string $text = '';

    public function rules(): array
    {
        return [
            'recipients' => ['required', new RecipientsList()],
            'text' => ['required', 'max:4096']
        ];
    }

    public function messages(): array
    {
        return [
            'text.max' => 'Длина одного сообщения в личных чатах, группах и каналах — до 4096 символов.',
            '*.required' => 'Поле должно быть заполнено!'
        ];
    }

    public function store(): ?Action
    {
        $attributes = $this->validate();

        $recipientsJSON = json_encode(array_map(function ($elem) {
            return  trim($elem);
        }, explode(',', $attributes['recipients'])));

        $action = Action::create([
            'recipients' => $recipientsJSON,
            'text' => $attributes['text'],
            'user_id' => auth()->id(),
            'action_type_id' => 1
        ]);

        return $action;
    }
}
