<div>
    <form wire:submit="updateName" action="" class="row">
        <label for="groupUpdateName" class="col-2 col-form-label">Имя</label>
        <div class="col-10">
            <input type="text" class="form-control-plaintext" readonly id="groupUpdateName" value="{{$group->name}}">
        </div>
    </form>

    <form wire:submit="updateDescription" action="" class="row">
        <label for="groupUpdateName" class="col-2 col-form-label">Описание</label>
        <div class="col-10">
            <textarea class="form-control-plaintext" readonly id="" rows="{{$rows}}"
                      style="resize: none;">{{$group->description}}</textarea>
        </div>
    </form>

    <div class="row row-cols-3 justify-content-center">
        <button
            wire:click="startBotListManagement({{$group->id}})"
            class="col btn btn-sm btn-success bg-gradient"
            type="button"
        >Добавить</button>
    </div>
</div>
