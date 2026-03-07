@extends('layouts.admin')
@section('title', 'Stocks')
@section('header', 'Gestion des Stocks')

@section('content')
<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden flex flex-col">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Article</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Quantité actuelle</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($burgers as $burger)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 shrink-0 overflow-hidden">
                                @if($burger->image_path)
                                <img src="{{ $burger->image_path }}" class="h-full w-full object-cover">
                                @else
                                <span class="material-symbols-outlined">lunch_dining</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ $burger->name }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold {{ $burger->stock_quantity == 0 ? 'text-red-600' : ($burger->stock_quantity < 10 ? 'text-orange-600' : 'text-slate-900') }}">{{ $burger->stock_quantity }}</span>
                            <span class="text-xs text-gray-500">unités</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($burger->stock_quantity == 0)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                            Rupture
                        </span>
                        @elseif($burger->stock_quantity < 10)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-orange-50 text-orange-700 border border-orange-100">
                            Faible
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                            Optimal
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <form action="{{ route('admin.stocks.update', $burger) }}" method="POST" class="flex items-center justify-end gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="stock_quantity" value="{{ $burger->stock_quantity }}" class="w-20 px-2 py-1 border border-gray-300 rounded text-sm">
                            <button type="submit" class="flex items-center gap-1 px-3 py-1.5 bg-white border border-gray-300 hover:border-primary hover:text-primary text-slate-600 rounded-lg text-xs font-medium transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">save</span>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
