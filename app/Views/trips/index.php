<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1>Viagens</h1>
<a href="/trips/new">+ Nova viagem</a>

<table border="1" cellpadding="6">
    <tr>
        <th>Veículo</th>
        <th>Motoristas</th>
        <th>Período</th>
        <th>KM</th>
        <th></th>
    </tr>
    <?php foreach ($trips as $trip): ?>
        <tr>
            <td><?= esc($trip['vehicle_id']) ?></td>
            <td>
                <?= esc(implode(', ', array_column($trip['drivers'], 'name'))) ?>
            </td>
            <td><?= esc($trip['start_datetime']) ?> até <?= esc($trip['end_datetime']) ?></td>
            <td><?= esc($trip['initial_km']) ?> → <?= esc($trip['final_km']) ?></td>
            <td>
                <a href="/trips/edit/<?= $trip['id'] ?>">Editar</a>
                <a href="/trips/remove/<?= $trip['id'] ?>">Excluir</a>
            </td>
        </tr>
    <?php endforeach ?>
</table>

<?= $this->endSection() ?>