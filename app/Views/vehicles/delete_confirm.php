<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1>Excluir Veículo</h1>
<p>Confirma a exclusão de <strong><?= esc($vehicles['model']) . ' Placa:' . esc($vehicles['plate']) ?></strong>?</p>

<form method="post" action="/vehicles/delete/<?= $vehicles['id'] ?>">
    <?= csrf_field() ?>
    <button type="submit">Confirmar exclusão</button>
</form>
<a href="/vehicles">Cancelar</a>

<?= $this->endSection() ?>