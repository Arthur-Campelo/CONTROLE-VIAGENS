<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1>Motoristas</h1>
<a href="/drivers/new">+ Novo motorista</a>

<table border="1" cellpadding="6">
    <tr>
        <th>Nome</th>
        <th>Nascimento</th>
        <th>CNH</th>
        <th></th>
    </tr>
    <?php foreach ($drivers as $driver): ?>
        <tr>
            <td><?= esc($driver['name']) ?></td>
            <td><?= esc($driver['birth_date']) ?></td>
            <td><?= esc($driver['cnh_number']) ?></td>
            <td>
                <a href="/drivers/edit/<?= $driver['id'] ?>">Editar</a>
                <a href="/drivers/remove/<?= $driver['id'] ?>">Excluir</a>
            </td>
        </tr>
    <?php endforeach ?>
</table>

<?= $this->endSection() ?>