<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1>Veículos</h1>
<a href="/vehicles/new">+ Novo veículo</a>

<table border="1" cellpadding="6">
    <tr><th>Modelo</th><th>Ano</th><th>Renavam</th><th>Placa</th><th></th></tr>
    <?php foreach ($vehicles as $vehicle): ?>
        <tr>
            <td><?= esc($vehicle['model']) ?></td>
            <td><?= esc($vehicle['year']) ?></td>
            <td><?= esc($vehicle['renavam']) ?></td>
            <td><?= esc($vehicle['plate']) ?></td>
            <td>
                <a href="/vehicles/edit/<?= $vehicle['id'] ?>">Editar</a>
                <a href="/vehicles/remove/<?= $vehicle['id'] ?>">Excluir</a>
            </td>
        </tr>
    <?php endforeach ?>
</table>

<?= $this->endSection() ?>