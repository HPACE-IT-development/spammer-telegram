<div wire:ignore.self class="modal fade" id="botCreateModal" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5">Добавить аккаунт Telegram</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <livewire:dynamic-component :is="$currentStep" :bot="$bot" :key="$currentStep"/>
        </div>
    </div>
</div>

@script
<script>
    document.addEventListener('livewire:initialized', () => {
        $wire.on('hide-bot-create-modal', () => {
            let element = document.getElementById('closeBotCreateModal');
            element.dispatchEvent(new Event('click', { 'bubbles': true }));
        });
    });
</script>
@endscript
