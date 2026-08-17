<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1><?= $vehicle ? 'Editar veículo' : 'Novo veículo' ?></h1>

<form method="post" action="<?= $vehicle ? '/vehicles/update/' . $vehicle['id'] : '/vehicles/create' ?>">
    <?= csrf_field() ?>

    <label>Modelo</label>
    <input type="text" name="model" value="<?= esc(old('model', $vehicle['model'] ?? '')) ?>" required><br>

    <label>Ano</label>
    <input type="number" name="year" value="<?= esc(old('year', $vehicle['year'] ?? '')) ?>" required><br>

    <label>Data de aquisição</label>
    <input type="date" name="acquisition_date"
        value="<?= esc(old('acquisition_date', $vehicle['acquisition_date'] ?? '')) ?>" required><br>

    <label>KM na aquisição</label>
    <input type="number" name="acquisition_km"
        value="<?= esc(old('acquisition_km', $vehicle['acquisition_km'] ?? '')) ?>" required><br>

    <label>Renavam</label>
    <input type="text" name="renavam" value="<?= esc(old('renavam', $vehicle['renavam'] ?? '')) ?>" required><br>

    <label>Placa</label>
    <input type="text" name="plate" value="<?= esc(old('plate', $vehicle['plate'] ?? '')) ?>" required><br>

    <button type="submit">Salvar</button>
</form>

<?= $this->endSection() ?>