<div id="settings-group-create-content" class="tab-pane fade show">
    <form wire:submit="save" class="d-flex flex-column align-items-center" action="">
        <h2 class="h2 mb-4">Создать группу</h2>

        <div class="mb-3 w-75">
            <label class="form-label" for="groupCreateNameInput">Название группы:</label>
            <input
                wire:model="form.name"
                type="text"
                class="form-control {{$errors->has('form.name')? 'is-invalid': ''}}"
                id="groupCreateNameInput"
                placeholder="Введите название"
            >

            @error('form.name')
                <span class="invalid-feedback">{{$message}}</span>
            @enderror
        </div>

        <div class="mb-5 w-75">
            <label class="form-label" for="groupCreateDescriptionInput">Описание</label>
            <input
                wire:model="form.description"
                type="text"
                class="form-control {{$errors->has('form.description')? 'is-invalid': ''}}"
                id="groupCreateDescriptionInput"
                placeholder="Введите описание"
            >

            @error('form.description')
                <span class="invalid-feedback">{{$message}}</span>
            @enderror
        </div>

        <input class="w-75 form-control btn btn-light" type="submit" value="Применить">
    </form>
</div>
