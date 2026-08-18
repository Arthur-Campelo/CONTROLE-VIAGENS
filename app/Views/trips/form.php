<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="mx-auto max-w-2xl">
    <div class="card p-8">
        <h1 class="mb-6 text-xl font-bold text-slate-900">
            <?= $trip ? 'Editar viagem' : 'Nova viagem' ?>
        </h1>

        <form method="post" action="<?= $trip ? '/trips/update/' . $trip['id'] : '/trips/create' ?>">
            <?= csrf_field() ?>

            <div class="space-y-5">
                <div>
                    <label class="label">Veículo</label>
                    <select name="vehicle_id" class="input" required>
                        <option value="">Selecione</option>
                        <?php foreach ($vehicles as $vehicle): ?>
                            <option value="<?= $vehicle['id'] ?>" <?= ($trip['vehicle_id'] ?? null) == $vehicle['id'] ? 'selected' : '' ?>>
                                <?= esc($vehicle['model']) ?> — <?= esc($vehicle['plate']) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div>
                    <label class="label">Motoristas</label>
                    <select name="driver_ids[]" class="input h-32" multiple required>
                        <?php foreach ($drivers as $driver): ?>
                            <option value="<?= $driver['id'] ?>" <?= in_array($driver['id'], $selectedDrivers) ? 'selected' : '' ?>>
                                <?= esc($driver['name']) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <p class="mt-1 text-xs text-slate-400">Segure Ctrl (ou Cmd no Mac) para selecionar mais de um.</p>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="label">KM inicial</label>
                        <input type="number" name="initial_km" class="input"
                            value="<?= esc(old('initial_km', $trip['initial_km'] ?? '')) ?>" required>
                    </div>
                    <div>
                        <label class="label">KM final</label>
                        <input type="number" name="final_km" class="input"
                            value="<?= esc(old('final_km', $trip['final_km'] ?? '')) ?>" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- to_datetime_local() (app_helper.php, Parte 13) converte o
                         formato do Postgres para o que o input datetime-local espera -->
                    <div>
                        <label class="label">Data/hora inicial</label>
                        <input type="datetime-local" name="start_datetime" class="input"
                            value="<?= esc(old('start_datetime', to_datetime_local($trip['start_datetime'] ?? null))) ?>"
                            required>
                    </div>
                    <div>
                        <label class="label">Data/hora de chegada</label>
                        <input type="datetime-local" name="end_datetime" class="input"
                            value="<?= esc(old('end_datetime', to_datetime_local($trip['end_datetime'] ?? null))) ?>"
                            required>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-6">
                <a href="/trips" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>