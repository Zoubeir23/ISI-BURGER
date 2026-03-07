@extends('layouts.admin')
@section('title', 'Commandes')
@section('header', 'Commandes')

@php
$statusLabels = [
    'pending'   => ['label' => 'En attente',    'class' => 'bg-orange-100 text-orange-800'],
    'preparing' => ['label' => 'En préparation','class' => 'bg-yellow-100 text-yellow-800'],
    'ready'     => ['label' => 'Prête',         'class' => 'bg-green-100 text-green-800'],
    'paid'      => ['label' => 'Payée',         'class' => 'bg-blue-100 text-blue-800'],
    'delivered' => ['label' => 'Livrée',        'class' => 'bg-purple-100 text-purple-800'],
    'cancelled' => ['label' => 'Annulée',       'class' => 'bg-red-100 text-red-800'],
];
@endphp

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
    <table class="w-full text-left border-collapse min-w-[600px]">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">#CMD</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Client</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Téléphone</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Total</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Statut</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Date</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($orders as $order)
            @php $badge = $statusLabels[$order->status] ?? ['label' => $order->status, 'class' => 'bg-gray-100 text-gray-800']; @endphp
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 text-sm font-medium text-slate-900">#{{ $order->id }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $order->client_name }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $order->client_phone }}</td>
                <td class="px-6 py-4 text-sm font-bold text-slate-900">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge['class'] }}">
                        {{ $badge['label'] }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-6 py-4 text-sm font-medium">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-primary hover:text-red-900">Voir</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <div class="px-6 py-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
