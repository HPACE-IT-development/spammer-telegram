<form wire:key="phone-login" wire:submit="save">
    <div class="w-75 modal-body py-1 mx-auto">
        <div>
            <input
                wire:model="phone"
                class="form-control {{$errors->has('phone')? 'is-invalid': ''}}"
                placeholder="Номер телефона"
            >
            @error('phone')
                <span class="invalid-feedback">{{$message}}</span>
            @endif
        </div>
    </div>

    <div class="modal-footer border-0">
        <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal">Отменить</button>
        <button type="submit" class="btn btn-primary">Получить код</button>
    </div>
</form>

