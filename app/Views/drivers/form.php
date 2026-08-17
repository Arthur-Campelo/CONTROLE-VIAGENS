<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1><?= $driver ? 'Editar motorista' : 'Novo motorista' ?></h1>

<form method="post" action="<?= $driver ? '/drivers/update/' . $driver['id'] : '/drivers/create' ?>">
    <?= csrf_field() ?>

    <label>Nome</label>
    <input type="text" name="name" value="<?= esc(old('name', $driver['name'] ?? '')) ?>" required><br>

    <label>Data de nascimento</label>
    <input type="date" name="birth_date" value="<?= esc(old('birth_date', $driver['birth_date'] ?? '')) ?>" required><br>

    <label>N° da CNH</label>
    <input type="text" name="cnh_number" value="<?= esc(old('cnh_number', $driver['cnh_number'] ?? '')) ?>" required><br>

    <button type="submit">Salvar</button>
</form>

<?= $this->endSection() ?>