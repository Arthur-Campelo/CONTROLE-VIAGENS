<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1>
    <?= $trip ? 'Editar viagem' : 'Nova viagem' ?>
</h1>

<form method="post" action="<?= $trip ? '/trips/update/' . $trip['id'] : '/trips/create' ?>">
    <?= csrf_field() ?>

    <label>Veículo</label>
    <select name="vehicle_id" required>
        <option value="">Selecione</option>
        <?php foreach ($vehicles as $vehicle): ?>
            <option value="<?= $vehicle['id'] ?>" <?= ($trip['vehicle_id'] ?? null) == $vehicle['id'] ? 'selected' : '' ?>>
                <?= esc($vehicle['model']) ?> —
                <?= esc($vehicle['plate']) ?>
            </option>
        <?php endforeach ?>
    </select><br>

    <label>Motoristas (segure Ctrl para selecionar mais de um)</label>
    <select name="driver_ids[]" multiple required>
        <?php foreach ($drivers as $driver): ?>
            <option value="<?= $driver['id'] ?>" <?= in_array($driver['id'], $selectedDrivers) ? 'selected' : '' ?>>
                <?= esc($driver['name']) ?>
            </option>
        <?php endforeach ?>
    </select><br>

    <label>KM inicial</label>
    <input type="number" name="initial_km" value="<?= esc(old('initial_km', $trip['initial_km'] ?? '')) ?>"
        required><br>

    <label>KM final</label>
    <input type="number" name="final_km" value="<?= esc(old('final_km', $trip['final_km'] ?? '')) ?>" required><br>

    <label>Data/hora inicial</label>
    <input type="datetime-local" name="start_datetime"
        value="<?= esc(old('start_datetime', $trip['start_datetime'] ?? '')) ?>" required><br>

    <label>Data/hora de chegada</label>
    <input type="datetime-local" name="end_datetime"
        value="<?= esc(old('end_datetime', $trip['end_datetime'] ?? '')) ?>" required><br>

    <button type="submit">Salvar</button>
</form>

<?= $this->endSection() ?>