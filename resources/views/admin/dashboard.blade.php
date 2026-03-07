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
        <h3 class="font-bold text-slate-900 mb-4">Commandes par Mois</h3>
        <canvas id="ordersChart"></canvas>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-bold text-slate-900 mb-4">Ventes par Catégorie</h3>
        <canvas id="salesChart"></canvas>
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
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ordersCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: 'Commandes',
                data: @json($ordersData),
                backgroundColor: '#f2240d',
                borderRadius: 4
            }]
        },
        options: { responsive: true }
    });

    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'doughnut',
        data: {
            labels: @json($categories),
            datasets: [{
                data: @json($salesData),
                backgroundColor: ['#f2240d', '#10B981', '#F59E0B', '#3B82F6', '#6366F1'],
            }]
        },
        options: { responsive: true }
    });
</script>
@endsection
