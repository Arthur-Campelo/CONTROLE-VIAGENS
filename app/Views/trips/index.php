<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Viagens</h1>
        <p class="text-sm text-slate-500">Gerencie os registros de viagens</p>
    </div>
    <a href="/trips/new" class="btn-primary">+ Nova viagem</a>
</div>

<div class="card overflow-hidden">
    <table class="w-full text-left">
        <thead class="border-b border-slate-200 bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Veículo</th>
                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Motoristas</th>
                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Período</th>
                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">KM</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php foreach ($trips as $trip): ?>
                <tr class="hover:bg-slate-50">
                    <!-- vem do join feito em getTripsWithDetails() -->
                    <td class="px-4 py-3 text-sm text-slate-700">
                        <?= esc($trip['vehicle_model']) ?>
                        <span class="ml-1 text-xs text-slate-400"><?= esc($trip['vehicle_plate']) ?></span>
                    </td>
                    
                    <td class="px-4 py-3 text-sm text-slate-700">
                        <?= esc(implode(', ', array_column($trip['drivers'], 'name'))) ?></td>
                    <td class="px-4 py-3 text-sm text-slate-700"><?= esc($trip['start_datetime']) ?> até
                        <?= esc($trip['end_datetime']) ?></td>
                    <td class="px-4 py-3 text-sm text-slate-700"><?= esc($trip['initial_km']) ?> →
                        <?= esc($trip['final_km']) ?></td>
                    <td class="px-4 py-3 text-right text-sm whitespace-nowrap">
                        <a href="/trips/edit/<?= $trip['id'] ?>"
                            class="font-medium text-brand-600 hover:text-brand-700">Editar</a>
                        <span class="mx-1 text-slate-300">/</span>
                        <a href="/trips/remove/<?= $trip['id'] ?>"
                            class="font-medium text-red-600 hover:text-red-700">Excluir</a>
                    </td>
                </tr>
            <?php endforeach ?>
            <?php if (empty($trips)): ?>
                <tr>
                    <td colspan="5" class="px-4 py-10 text-center text-sm text-slate-400">Nenhuma viagem registrada ainda.
                    </td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>