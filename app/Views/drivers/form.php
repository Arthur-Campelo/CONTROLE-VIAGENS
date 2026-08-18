<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="mx-auto max-w-2xl">
    <div class="card p-8">
        <h1 class="mb-6 text-xl font-bold text-slate-900">
            <?= $driver ? 'Editar motorista' : 'Novo motorista' ?>
        </h1>

        <form method="post" action="<?= $driver ? '/drivers/update/' . $driver['id'] : '/drivers/create' ?>">
            <?= csrf_field() ?>

            <div class="space-y-5">
                <div>
                    <label class="label">Nome</label>
                    <input type="text" name="name" class="input" value="<?= esc(old('name', $driver['name'] ?? '')) ?>"
                        required>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="label">Data de nascimento</label>
                        <input type="date" name="birth_date" class="input"
                            value="<?= esc(old('birth_date', $driver['birth_date'] ?? '')) ?>" required>
                    </div>
                    <div>
                        <label class="label">N° da CNH</label>
                        <input type="text" name="cnh_number" class="input"
                            value="<?= esc(old('cnh_number', $driver['cnh_number'] ?? '')) ?>" required>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-6">
                <a href="/drivers" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>