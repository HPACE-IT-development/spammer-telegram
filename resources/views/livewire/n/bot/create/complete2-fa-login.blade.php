<div>
    <form wire:key="complete2-fa-login" wire:submit="save">
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
                    wire:model="password"
                    type="password"
                    class="form-control {{$errors->has('password')? 'is-invalid': ''}}"
                    placeholder="Облачный пароль"
                >

                @error('password')
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
            <button type="submit" class="btn btn-primary">Подтвердить</button>
        </div>
    </form>

</div>
