<div wire:ignore.self class="modal fade" id="actionCreateModal" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5">Добавить задачу</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>

            <form wire:submit="save">
                <div class="modal-body">
                    <select wire:model.change="selectedType" class="form-select form-select-sm mb-3">
                        @foreach($types as $key => $type)
                            <option
                                wire:key="{{$key}}"
                                value="{{$type['title']}}"
                                {{($selectedType === $type['title'])? 'selected': ''}}
                            >{{$type['desc_ru']}}</option>
                        @endforeach
                    </select>
                    @if($selectedType === 'newsletter')
                        <div class="mb-3">
                            <label class="form-label mb-1" for="actionCreateNewsletterRecipients">Получатели</label>
                            <textarea
                                wire:model="newsletterForm.recipients"
                                class="form-control {{$errors->has('newsletterForm.recipients')? 'is-invalid': ''}}"
                                id="actionCreateNewsletterRecipients"
                                cols="10" rows="4"></textarea>
                            @error('newsletterForm.recipients')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label mb-1" for="actionCreateNewsletterText">Текст сообщения</label>
                            <textarea
                                wire:model="newsletterForm.text"
                                class="form-control {{$errors->has('newsletterForm.text')? 'is-invalid': ''}}"
                                id="actionCreateNewsletterText"
                                cols="10" rows="4"></textarea>
                            @error('newsletterForm.text')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button id="closeActionCreateModal" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </div>
            </form>
        </div>
    </div>
</div>

@script
<script>
    document.addEventListener('livewire:initialized', () => {
        $wire.on('hide-action-create-modal', () => {
            let element = document.getElementById('closeActionCreateModal');
            element.dispatchEvent(new Event('click', { 'bubbles': true }));
        });
    });
</script>
@endscript
