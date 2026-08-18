<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link href="/css/tailwind.css" rel="stylesheet">
    <title>Controle de Viagens</title>
</head>

<body class="min-h-screen bg-slate-50 antialiased">

    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex h-16 max-w-5xl items-center justify-between px-4 sm:px-6">
            <span class="text-lg font-bold text-slate-900">Controle de Viagens</span>

            <?php if (auth()->loggedIn()): ?>
                <nav class="flex items-center gap-6">
                    <a href="/vehicles" class="nav-link">Veículos</a>
                    <a href="/drivers" class="nav-link">Motoristas</a>
                    <a href="/trips" class="nav-link">Viagens</a>
                    <span class="h-5 w-px bg-slate-200"></span>
                    <span class="text-sm text-slate-500">
                        Olá, <span class="font-medium text-slate-700"><?= esc(auth()->user()->username) ?></span>
                    </span>
                    <a href="/logout" class="nav-link">Sair</a>
                </nav>
            <?php else: ?>
                <a href="/login" class="btn-primary">Entrar</a>
            <?php endif ?>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-8 sm:px-6">

        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert-success mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mt-0.5 h-5 w-5 flex-shrink-0">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
                <span><?= esc(session()->getFlashdata('message')) ?></span>
            </div>
        <?php endif ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert-error mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mt-0.5 h-5 w-5 flex-shrink-0">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                </svg>
                <ul class="space-y-0.5">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <?= $this->renderSection('content') ?>

    </main>

</body>

</html>