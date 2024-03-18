<div wire:ignore.self class="modal fade" id="botCreateModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5">Добавить аккаунт Telegram</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>

            <livewire:dynamic-component :is="$currentStep" :bot="$bot" :key="$currentStep"/>
        </div>
    </div>
</div>
