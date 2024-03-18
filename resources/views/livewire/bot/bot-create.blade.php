<?php

use App\Enums\TelegramAuthStatusEnum;

?>

<div wire:transition class="w-75 mx-auto mt-3">
    <form
        @if(!$bot)
            wire:submit="phoneLogin"
        @elseif(TelegramAuthStatusEnum::from($authStatus) == TelegramAuthStatusEnum::WAITING_CODE)
            wire:submit="completePhoneLogin"
        @elseif(TelegramAuthStatusEnum::from($authStatus) == TelegramAuthStatusEnum::WAITING_PASSWORD)
            wire:submit="complete2FaLogin"
        @endif
        action=""
    >
        <h3 class="h3 text-center mb-5">Добавить аккаунт</h3>

        <div class="w-50 mx-auto">
            <div class="mb-3 position-relative">
                <label class="form-label" for="BotCreatePhone">Номер телефона</label>
                <input
                    wire:model="form.phone"
                    class="form-control {{$errors->has('form.phone')? 'is-invalid': ''}}"
                    id="BotCreatePhone"
                    placeholder="Введите номер телефона"
                    {{$bot? 'disabled ': ''}}
                >
                @error('form.phone')
                    <span class="invalid-feedback">{{$message}}</span>
                @endif

                @if($bot)
                    <div
                        class="col-4 position-absolute bottom-0 d-flex flex-column justify-content-end"
                        style="right: -100px;"
                    >
                        <input wire:click="resetComponent('remove')" type="text"
                               class="form-control btn btn-outline-secondary"
                               value="Сбросить">
                    </div>
                @endif
            </div>

            @if($bot)
                @if(TelegramAuthStatusEnum::from($authStatus) == TelegramAuthStatusEnum::WAITING_CODE)
                    <div class="mb-3">
                        <label class="form-label" for="BotCreateCode">Код подтверждения</label>
                        <input
                            wire:model="form.code"
                            class="form-control {{$errors->has('form.code')? 'is-invalid': ''}}"
                            id="BotCreateCode"
                            type="text"
                            placeholder="Введите код подтверждения"
                        >
                        @error('form.code')
                        <span class="invalid-feedback">{{$message}}</span>
                        @endif
                    </div>
                @elseif(TelegramAuthStatusEnum::from($authStatus) == TelegramAuthStatusEnum::WAITING_PASSWORD)
                    <div class="mb-3">
                        <label class="form-label" for="BotCreatePassword">Облачный пароль</label>
                        <input
                            wire:model="form.password"
                            class="form-control {{$errors->has('form.password')? 'is-invalid': ''}}"
                            id="BotCreatePassword"
                            type="password"
                            placeholder="Введите ваш облачный пароль"
                        >
                        @error('form.password')
                        <span class="invalid-feedback">{{$message}}</span>
                        @endif
                    </div>
                @endif
            @endif

            <button class="btn btn-primary w-100" type="submit" wire:loading.attr="disabled">
                <span wire:loading.remove>{{$bot? 'Подтвердить': 'Добавить'}}</span>
                <span wire:loading.class.remove="visually-hidden" class="spinner-border spinner-border-sm visually-hidden"></span>
                <span wire:loading.class.remove="visually-hidden" class="visually-hidden">Загрузка...</span>
            </button>
        </div>
    </form>
</div>
