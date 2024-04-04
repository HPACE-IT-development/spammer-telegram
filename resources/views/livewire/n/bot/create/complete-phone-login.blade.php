<form wire:key="complete-phone-login" wire:submit="save">
    <div class="w-75 modal-body py-1 mx-auto">
        <input
            class="form-control mb-3"
            placeholder="Номер телефона"
            value="{{$bot->phone}}"
            disabled
            readonly
        >

        <div>
            <input
                wire:model="code"
                class="form-control {{$errors->has('code')? 'is-invalid': ''}}"
                placeholder="Код подтверждения"
            >

            @error('code')
                <span class="invalid-feedback">{{$message}}</span>
            @enderror
        </div>
    </div>

    <div class="modal-footer border-0">
        <button
            wire:click="dispatchTo('n.bot.create.bot-create', 'bot-create-cancel')"
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal">Отменить</button>
        <button type="submit" class="btn btn-primary">Отправить код</button>
    </div>
</form>

