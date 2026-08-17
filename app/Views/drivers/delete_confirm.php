<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1>Excluir motorista</h1>
<p>Confirma a exclusão de <strong><?= esc($driver['name']) ?></strong>?</p>

<form method="post" action="/drivers/delete/<?= $driver['id'] ?>">
    <?= csrf_field() ?>
    <button type="submit">Confirmar exclusão</button>
</form>
<a href="/drivers">Cancelar</a>

<?= $this->endSection() ?>