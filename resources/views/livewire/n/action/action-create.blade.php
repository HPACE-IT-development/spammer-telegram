<div wire:ignore.self class="modal fade" id="actionCreateModal" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5">Добавить задачу</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <select wire:model.change="selectedType" class="form-select form-select-sm">
                    @foreach($types as $key => $type)
                        <option
                            wire:key="{{$key}}"
                            value="{{$type['title']}}"
                            {{($selectedType === $type['title'])? 'selected': ''}}
                        >{{$type['desc_ru']}}</option>
                    @endforeach
                </select>
                @if($selectedType === 'newsletter')
                    <form action="">

                    </form>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary">Добавить</button>
            </div>
        </div>
    </div>
</div>
