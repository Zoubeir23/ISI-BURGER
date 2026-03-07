@extends('layouts.admin')
@section('title', 'Burgers')
@section('header', 'Gestion des Burgers')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-sm text-gray-500">{{ $burgers->total() }} burger(s) au total</p>
    <a href="{{ route('admin.burgers.create') }}"
        class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2.5 rounded-xl hover:bg-red-700 transition font-semibold text-sm shadow-lg shadow-primary/20">
        <span class="material-symbols-outlined text-base">add_circle</span>
        Ajouter un Burger
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">
    @forelse($burgers as $burger)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition-shadow">
        <div class="h-44 sm:h-48 bg-gray-100 relative">
            @if($burger->image_path)
            <img src="{{ $burger->image_path }}" alt="{{ $burger->name }}" class="w-full h-full object-cover">
            @else
            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                <span class="material-symbols-outlined text-5xl text-gray-300">lunch_dining</span>
            </div>
            @endif
        </div>
        <div class="p-4 sm:p-5 flex-1 flex flex-col">
            <div class="flex items-start justify-between gap-2 mb-1">
                <h3 class="text-base font-bold text-slate-900 leading-tight">{{ $burger->name }}</h3>
                @if($burger->category)
                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full whitespace-nowrap flex-shrink-0">{{ $burger->category }}</span>
                @endif
            </div>
            <p class="text-primary font-bold text-base">{{ number_format($burger->price, 0, ',', ' ') }} FCFA</p>
            <p class="text-gray-400 text-sm mt-1 mb-4 line-clamp-2">{{ $burger->description ?: 'Aucune description.' }}</p>
            <div class="mt-auto flex justify-between items-center">
                <span class="text-sm font-semibold {{ $burger->stock_quantity > 10 ? 'text-green-600' : ($burger->stock_quantity > 0 ? 'text-orange-500' : 'text-red-500') }}">
                    Stock : {{ $burger->stock_quantity }}
                </span>
                <a href="{{ route('admin.burgers.edit', $burger) }}"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-600 hover:text-primary transition">
                    <span class="material-symbols-outlined text-base">edit</span>
                    Modifier
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-16 text-gray-400">
        <span class="material-symbols-outlined text-5xl block mb-3">lunch_dining</span>
        Aucun burger trouvé.
        <a href="{{ route('admin.burgers.create') }}" class="text-primary hover:underline ml-1">Ajouter le premier</a>
    </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $burgers->links() }}
</div>
@endsection
