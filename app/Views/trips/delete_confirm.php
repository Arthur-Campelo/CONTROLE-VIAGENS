<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1>Excluir Viagem</h1>
<p>Confirma a exclusão da viagem?</p>

<form method="post" action="/trips/delete/<?= $trip['id'] ?>">
    <?= csrf_field() ?>
    <button type="submit">Confirmar exclusão</button>
</form>
<a href="/trips">Cancelar</a>

<?= $this->endSection() ?>