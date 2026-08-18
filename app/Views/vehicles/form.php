<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="mx-auto max-w-2xl">
    <div class="card p-8">
        <h1 class="mb-6 text-xl font-bold text-slate-900">
            <?= $vehicle ? 'Editar veículo' : 'Novo veículo' ?>
        </h1>

        <form method="post" action="<?= $vehicle ? '/vehicles/update/' . $vehicle['id'] : '/vehicles/create' ?>">
            <?= csrf_field() ?>

            <div class="space-y-5">
                <div>
                    <label class="label">Modelo</label>
                    <input type="text" name="model" class="input"
                        value="<?= esc(old('model', $vehicle['model'] ?? '')) ?>" required>
                </div>

                <div>
                    <label class="label">Ano</label>
                    <input type="number" name="year" class="input"
                        value="<?= esc(old('year', $vehicle['year'] ?? '')) ?>" required>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="label">Data de aquisição</label>
                        <input type="date" name="acquisition_date" class="input"
                            value="<?= esc(old('acquisition_date', $vehicle['acquisition_date'] ?? '')) ?>" required>
                    </div>
                    <div>
                        <label class="label">KM na aquisição</label>
                        <input type="number" name="acquisition_km" class="input"
                            value="<?= esc(old('acquisition_km', $vehicle['acquisition_km'] ?? '')) ?>" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="label">Renavam</label>
                        <input type="text" name="renavam" class="input"
                            value="<?= esc(old('renavam', $vehicle['renavam'] ?? '')) ?>" required>
                    </div>
                    <div>
                        <label class="label">Placa</label>
                        <input type="text" name="plate" class="input"
                            value="<?= esc(old('plate', $vehicle['plate'] ?? '')) ?>" required>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-6">
                <a href="/vehicles" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>