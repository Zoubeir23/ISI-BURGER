@extends('layouts.admin')
@section('title', 'Burgers')
@section('header', 'Gestion des Burgers')

@section('content')
{{-- Onglets Actifs / Archivés --}}
<div class="flex items-center gap-2 mb-6 border-b border-gray-200 pb-3">
    <a href="{{ route('admin.burgers.index', ['filter' => 'active']) }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-semibold transition
        {{ $filter === 'active' ? 'bg-primary text-white shadow' : 'text-gray-500 hover:bg-gray-100' }}">
        <span class="material-symbols-outlined text-base">lunch_dining</span>
        Actifs <span class="ml-1 text-xs opacity-80">({{ $activeCount }})</span>
    </a>
    <a href="{{ route('admin.burgers.index', ['filter' => 'archived']) }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-semibold transition"
        style="{{ $filter === 'archived' ? 'background: var(--admin-text-muted, #6b7280); color: white; box-shadow: 0 1px 4px rgba(0,0,0,0.15);' : 'color: var(--admin-text-muted, #6b7280);' }}"
        @if($filter !== 'archived') onmouseover="this.style.background='var(--admin-content-bg, #f1f5f9)'" onmouseout="this.style.background=''" @endif>
        <span class="material-symbols-outlined text-base">archive</span>
        Archivés <span class="ml-1 text-xs opacity-80">({{ $archivedCount }})</span>
    </a>
    <div class="flex-1"></div>
    @if($filter === 'active')
    <a href="{{ route('admin.burgers.create') }}"
        class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2.5 rounded-xl hover:bg-red-700 transition font-semibold text-sm shadow-lg shadow-primary/20">
        <span class="material-symbols-outlined text-base">add_circle</span>
        Ajouter un Burger
    </a>
    @endif
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">
    @forelse($burgers as $burger)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition-shadow {{ $burger->is_archived ? 'opacity-75' : 'cursor-pointer' }}"
         @if(!$burger->is_archived) onclick="window.location='{{ route('admin.burgers.edit', $burger) }}'" @endif>
        <div class="h-44 sm:h-48 bg-gray-100 relative">
            @if($burger->image_path)
            <img src="{{ $burger->image_path }}" alt="{{ $burger->name }}" class="w-full h-full object-cover {{ $burger->is_archived ? 'grayscale' : '' }}">
            @else
            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                <span class="material-symbols-outlined text-5xl text-gray-300">lunch_dining</span>
            </div>
            @endif
            @if($burger->is_archived)
            <div class="absolute top-2 left-2 bg-gray-800 text-white text-xs font-bold px-2.5 py-1 rounded-full">Archivé</div>
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
                <div class="flex items-center gap-2">
                    @if($burger->is_archived)
                        {{-- Restaurer --}}
                        <form action="{{ route('admin.burgers.restore', $burger) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="inline-flex items-center gap-1 text-sm font-medium text-green-600 hover:text-green-800 transition" title="Restaurer">
                                <span class="material-symbols-outlined text-base">unarchive</span>
                                Restaurer
                            </button>
                        </form>
                        {{-- Supprimer définitivement --}}
                        <form id="delete-form-{{ $burger->id }}" action="{{ route('admin.burgers.destroy', $burger) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                        </form>
                        <button type="button"
                            onclick="openDeleteModal('delete-form-{{ $burger->id }}', '{{ addslashes($burger->name) }}')"
                            class="inline-flex items-center gap-1 text-sm font-medium text-red-500 hover:text-red-700 transition" title="Supprimer">
                            <span class="material-symbols-outlined text-base">delete_forever</span>
                            Supprimer
                        </button>
                    @else
                        <a href="{{ route('admin.burgers.edit', $burger) }}"
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-600 hover:text-primary transition">
                            <span class="material-symbols-outlined text-base">edit</span>
                            Modifier
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-16 text-gray-400">
        <span class="material-symbols-outlined text-5xl block mb-3">{{ $filter === 'archived' ? 'archive' : 'lunch_dining' }}</span>
        @if($filter === 'archived')
            Aucun burger archivé.
        @else
            Aucun burger trouvé.
            <a href="{{ route('admin.burgers.create') }}" class="text-primary hover:underline ml-1">Ajouter le premier</a>
        @endif
    </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $burgers->links() }}
</div>

{{-- Modale confirmation suppression définitive --}}
<div id="delete-modal"
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     style="display:none; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px);">
    <div class="w-full max-w-sm rounded-2xl shadow-2xl p-6 flex flex-col gap-4"
         style="background:var(--admin-card-bg,#fff); border:1px solid var(--admin-card-border,#e5e7eb);">
        <div class="flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(239,68,68,0.12);">
                <span class="material-symbols-outlined" style="color:#ef4444;font-size:1.375rem;font-variation-settings:'FILL' 1;">delete_forever</span>
            </div>
            <div>
                <p class="font-bold text-base" style="color:var(--admin-text,#111827);">Supprimer définitivement&nbsp;?</p>
                <p class="text-sm mt-1" style="color:var(--admin-text-muted,#6b7280);">
                    Le burger <strong id="delete-burger-name" style="color:var(--admin-text,#111827);"></strong> sera supprimé de façon permanente. Cette action est irréversible.
                </p>
            </div>
        </div>
        <div class="flex justify-end gap-3 pt-1">
            <button type="button" onclick="closeDeleteModal()"
                class="px-5 py-2.5 rounded-xl text-sm font-semibold border transition"
                style="border-color:var(--admin-border,#e5e7eb);color:var(--admin-text-muted,#6b7280);"
                onmouseover="this.style.background='var(--admin-content-bg,#f1f5f9)'"
                onmouseout="this.style.background=''">
                Annuler
            </button>
            <button type="button" id="delete-confirm-btn"
                class="px-5 py-2.5 rounded-xl text-sm font-bold text-white transition shadow-lg"
                style="background:#ef4444;"
                onmouseover="this.style.background='#dc2626'"
                onmouseout="this.style.background='#ef4444'">
                Oui, supprimer
            </button>
        </div>
    </div>
</div>

<script>
let _deleteFormId = null;
function openDeleteModal(formId, name) {
    _deleteFormId = formId;
    document.getElementById('delete-burger-name').textContent = '« ' + name + ' »';
    document.getElementById('delete-confirm-btn').onclick = function () {
        document.getElementById(_deleteFormId).submit();
    };
    const m = document.getElementById('delete-modal');
    m.style.display = 'flex';
}
function closeDeleteModal() {
    document.getElementById('delete-modal').style.display = 'none';
    _deleteFormId = null;
}
document.getElementById('delete-modal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>
@endsection
