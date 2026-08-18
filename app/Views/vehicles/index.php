<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Veículos</h1>
        <p class="text-sm text-slate-500">Gerencie sua frota de veículos</p>
    </div>
    <a href="/vehicles/new" class="btn-primary">+ Novo veículo</a>
</div>

<div class="card overflow-hidden">
    <table class="w-full text-left">
        <thead class="border-b border-slate-200 bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Veículo / Ano</th>
                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Placa</th>
                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Renavam</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php foreach ($vehicles as $vehicle): ?>
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3 text-sm text-slate-700"><?= esc($vehicle['model']) ?> /
                        <?= esc($vehicle['year']) ?></td>
                    <td class="px-4 py-3"><span class="plate-badge"><?= esc($vehicle['plate']) ?></span></td>
                    <td class="px-4 py-3 text-sm text-slate-700"><?= esc($vehicle['renavam']) ?></td>
                    <td class="px-4 py-3 text-right text-sm whitespace-nowrap">
                        <a href="/vehicles/edit/<?= $vehicle['id'] ?>"
                            class="font-medium text-brand-600 hover:text-brand-700">Editar</a>
                        <span class="mx-1 text-slate-300">/</span>
                        <a href="/vehicles/remove/<?= $vehicle['id'] ?>"
                            class="font-medium text-red-600 hover:text-red-700">Excluir</a>
                    </td>
                </tr>
            <?php endforeach ?>
            <?php if (empty($vehicles)): ?>
                <tr>
                    <td colspan="4" class="px-4 py-10 text-center text-sm text-slate-400">Nenhum veículo cadastrado ainda.
                    </td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>