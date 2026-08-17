<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Controle de Viagens</title>
</head>

<body>
    <nav>
        <?php if (auth()->loggedIn()): ?>
            <a href="/vehicles">Veículos</a> |
            <a href="/drivers">Motoristas</a> |
            <a href="/trips">Viagens</a> |
            Olá, <?= esc(auth()->user()->username) ?> —
            <a href="/logout">Sair</a>
        <?php else: ?>
            <a href="/login">Entrar</a>
        <?php endif ?>
    </nav>
    <hr>

    <?php if (session()->getFlashdata('message')): ?>
        <p style="color: green;"><?= esc(session()->getFlashdata('message')) ?></p>
    <?php endif ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div style="color: red;">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <?= $this->renderSection('content') ?>
</body>

</html>