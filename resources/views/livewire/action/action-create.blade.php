<div class="pt-3">
    <h2 class="h2 text-center mb-5">Добавить рассылку</h2>
    <form wire:submit="save" class="mx-auto w-25" action="">
        <div class="mb-3">
            <label class="form-label fs-5" for="actionCreateRecipients">Получатели</label>
            <textarea
                wire:model="form.recipients"
                class="form-control {{$errors->has('form.recipients')? 'is-invalid': ''}}"
                id="actionCreateRecipients"
                cols="10" rows="4"></textarea>
            @error('form.recipients')
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fs-5" for="actionCreateText">Текст сообщения</label>
            <textarea
                wire:model="form.text"
                class="form-control {{$errors->has('form.text')? 'is-invalid': ''}}"
                id="actionCreateText"
                cols="10" rows="4"></textarea>
            @error('form.text')
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>

        <input class="form-control btn btn-primary" type="submit" value="Добавить задачу">
    </form>
</div>
