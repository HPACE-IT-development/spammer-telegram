<?php

namespace App\Livewire\Forms;

use App\Models\Action;
use App\Models\Image;
use App\Rules\RecipientsList;
use Illuminate\Support\Facades\Log;
use Livewire\Form;
use Livewire\WithFileUploads;

class ActionCreateNewsletterForm extends Form
{
    public string $recipients = '';

    public string $text = '';

    public $image;

    public function rules(): array
    {
        return [
            'recipients' => ['required', new RecipientsList()],
            'text' => (isset($this->image))? ['required', 'string', 'max:1024']: ['required', 'string', 'max:4096'],
            'image' => ['nullable', 'image']
        ];
    }

    public function messages(): array
    {
        $messages = [
            '*.required' => 'Поле должно быть заполнено!',
            'image' => 'Изображение должно иметь тип jpg, jpeg, png, bmp, gif, svg или webp.'
        ];

        $messages['text.max'] = isset($this->image)
            ? 'Максимальный текст рассылки с изображением 1024 символа.'
            : 'Максимальный текст рассылки без изображения 4096 символов.';

        return $messages;
    }

    public function store(): void
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


        if(isset($attributes['image'])) {
            $path = $attributes['image']->store('action/newsletter');
            Image::create([
                'action_id' => $action->id,
                'path' => $attributes['image']
            ]);
        }

        $this->resetAll();
    }

    public function resetAll(): void
    {
        $this->reset();
    }

    public function resetImage(): void
    {
        $this->reset('image');
    }
}
