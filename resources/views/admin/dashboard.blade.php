@extends('layouts.admin')

@section('title', 'Tableau de Bord')
@section('header', 'Tableau de Bord')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl p-6 border-t-4 border-primary shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-2 bg-primary/10 rounded-lg text-primary">
                <span class="material-symbols-outlined">schedule</span>
            </div>
        </div>
        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wide">Commandes en Cours</h3>
        <p class="text-3xl font-bold text-slate-900 mt-1">{{ $pendingOrders }}</p>
    </div>
    <div class="bg-white rounded-xl p-6 border-t-4 border-success shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-2 bg-success/10 rounded-lg text-success">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
        </div>
        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wide">Commandes Aujourd'hui</h3>
        <p class="text-3xl font-bold text-slate-900 mt-1">{{ $ordersToday }}</p>
    </div>
    <div class="bg-white rounded-xl p-6 border-t-4 border-warning shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-2 bg-warning/10 rounded-lg text-warning">
                <span class="material-symbols-outlined">payments</span>
            </div>
        </div>
        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wide">Recettes du Jour</h3>
        <p class="text-3xl font-bold text-slate-900 mt-1 tracking-tight">{{ number_format($revenueToday, 0, ',', ' ') }} <span class="text-base font-normal text-gray-500">FCFA</span></p>
    </div>
    <div class="bg-white rounded-xl p-6 border-t-4 border-red-400 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-2 bg-red-50 rounded-lg text-red-500">
                <span class="material-symbols-outlined">cancel</span>
            </div>
        </div>
        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wide">Annulées Aujourd'hui</h3>
        <p class="text-3xl font-bold text-slate-900 mt-1">{{ $cancelledToday }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-bold text-slate-900 mb-1">Commandes par Mois</h3>
        <p class="text-xs text-gray-400 mb-4">Année {{ date('Y') }}</p>
        <canvas id="ordersChart"></canvas>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-bold text-slate-900 mb-1">Ventes par Catégorie &amp; par Mois</h3>
        <p class="text-xs text-gray-400 mb-4">Quantités vendues par mois, groupées par catégorie</p>
        @if($allCategories->isEmpty())
            <div class="flex items-center justify-center h-48 text-gray-400 text-sm">
                Aucune donnée de catégorie disponible.
            </div>
        @else
            <canvas id="salesChart"></canvas>
        @endif
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
        <h3 class="text-lg font-bold text-slate-900 tracking-tight">Top Burgers (Quantité)</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Burger</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Vendus</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($topBurgers as $burger)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $burger->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $burger->order_items_sum_quantity ?? 0 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const MONTHS  = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
    const PALETTE = ['#ff6b35', '#10B981', '#F59E0B', '#3B82F6', '#8B5CF6', '#EC4899', '#14B8A6', '#F97316'];

    function isDarkMode() {
        return document.getElementById('html-root').classList.contains('dark-mode');
    }
    function chartColors() {
        const dark = isDarkMode();
        return {
            grid:      dark ? 'rgba(255,255,255,0.06)' : '#e5e7eb',
            tickColor: dark ? '#64748b' : '#9ca3af',
            legendColor: dark ? '#94a3b8' : '#6b7280',
        };
    }

    function buildOrdersChart() {
        const { grid, tickColor } = chartColors();
        return new Chart(document.getElementById('ordersChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: MONTHS,
                datasets: [{
                    label: 'Commandes',
                    data: @json($ordersData),
                    backgroundColor: 'rgba(255,107,53,0.85)',
                    borderRadius: 5,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1, color: tickColor }, grid: { color: grid } },
                    x: { ticks: { color: tickColor }, grid: { display: false } }
                }
            }
        });
    }

    @if($allCategories->isNotEmpty())
    function buildSalesChart() {
        const { grid, tickColor, legendColor } = chartColors();
        const categoryData = @json($monthlyCategoryData);
        const categories   = @json($allCategories);

        const salesDatasets = categories.map((cat, i) => ({
            label: cat,
            data: categoryData[cat] || Array(12).fill(0),
            backgroundColor: PALETTE[i % PALETTE.length],
            borderRadius: 4,
            borderSkipped: false,
        }));

        return new Chart(document.getElementById('salesChart').getContext('2d'), {
            type: 'bar',
            data: { labels: MONTHS, datasets: salesDatasets },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, padding: 16, font: { size: 11 }, color: legendColor }
                    }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1, color: tickColor }, grid: { color: grid } },
                    x: { ticks: { color: tickColor }, grid: { display: false } }
                }
            }
        });
    }
    @endif

    let ordersChartInstance = buildOrdersChart();
    @if($allCategories->isNotEmpty())
    let salesChartInstance  = buildSalesChart();
    @endif

    // Reconstruire les charts lors du changement de thème
    const _origToggle = window.toggleAdminTheme;
    window.toggleAdminTheme = function() {
        if (typeof _origToggle === 'function') _origToggle();
        setTimeout(() => {
            ordersChartInstance.destroy();
            ordersChartInstance = buildOrdersChart();
            @if($allCategories->isNotEmpty())
            salesChartInstance.destroy();
            salesChartInstance = buildSalesChart();
            @endif
        }, 50);
    };
</script>
@endsection
