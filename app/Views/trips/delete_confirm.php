<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="mx-auto max-w-md">
    <div class="card p-8 text-center">
        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-red-100">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.5" class="h-7 w-7 text-red-600">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
        </div>

        <h1 class="text-lg font-bold text-slate-900">Excluir viagem</h1>
        <p class="mt-2 text-sm text-slate-500">
            Confirma a exclusão da viagem <strong
                class="font-semibold text-slate-700">#<?= esc($trip['id']) ?></strong>?
            Esta ação não pode ser desfeita.
        </p>

        <div class="mt-6 space-y-2">
            <form method="post" action="/trips/delete/<?= $trip['id'] ?>">
                <?= csrf_field() ?>
                <button type="submit" class="btn-danger w-full">Confirmar exclusão</button>
            </form>
            <a href="/trips" class="btn-secondary block w-full">Cancelar</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>