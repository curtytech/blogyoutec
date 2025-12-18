<form wire:submit.prevent="authenticate">
    {{ $this->form }}

    <div class="mt-4">
        <button type="submit">Entrar</button>
    </div>
</form>