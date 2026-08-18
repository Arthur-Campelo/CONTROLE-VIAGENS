<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Motoristas</h1>
        <p class="text-sm text-slate-500">Gerencie os motoristas cadastrados</p>
    </div>
    <a href="/drivers/new" class="btn-primary">+ Novo motorista</a>
</div>

<div class="card overflow-hidden">
    <table class="w-full text-left">
        <thead class="border-b border-slate-200 bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Nome</th>
                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Nascimento</th>
                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">CNH</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php foreach ($drivers as $driver): ?>
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 text-sm font-medium text-slate-900"><?= esc($driver['name']) ?></td>
                    <td class="px-4 py-3 text-sm text-slate-700"><?= esc($driver['birth_date']) ?></td>
                    <td class="px-4 py-3 text-sm text-slate-700"><?= esc($driver['cnh_number']) ?></td>
                    <td class="px-4 py-3 text-right text-sm whitespace-nowrap">
                        <a href="/drivers/edit/<?= $driver['id'] ?>"
                            class="font-medium text-brand-600 hover:text-brand-700">Editar</a>
                        <span class="mx-1 text-slate-300">/</span>
                        <a href="/drivers/remove/<?= $driver['id'] ?>"
                            class="font-medium text-red-600 hover:text-red-700">Excluir</a>
                    </td>
                </tr>
            <?php endforeach ?>
            <?php if (empty($drivers)): ?>
                <tr>
                    <td colspan="4" class="px-4 py-10 text-center text-sm text-slate-400">Nenhum motorista cadastrado ainda.
                    </td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>