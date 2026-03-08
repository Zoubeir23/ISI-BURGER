@extends('layouts.admin')
@section('title', 'Modifier Burger')
@section('header', 'Modifier Burger')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-slate-700 to-slate-900 px-6 py-4">
            <h2 class="text-white font-bold text-lg flex items-center gap-2">
                <span class="material-symbols-outlined">edit</span>
                Modifier : {{ $burger->name }}
            </h2>
        </div>

        <form action="{{ route('admin.burgers.update', $burger) }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Nom du burger <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $burger->name) }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Prix (FCFA) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price', $burger->price) }}" min="0" step="50"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm" required>
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Catégorie</label>
                    <input type="text" name="category" value="{{ old('category', $burger->category) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm"
                        placeholder="Boeuf, Poulet, Végétarien...">
                    @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm resize-none">{{ old('description', $burger->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Stock <span class="text-red-500">*</span></label>
                <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $burger->stock_quantity) }}" min="0"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm" required>
                @error('stock_quantity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Zone image --}}
            <div class="border-t border-gray-100 pt-5">
                <p class="text-sm font-semibold text-slate-700 mb-3 flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">image</span>
                    Image du burger
                </p>

                {{-- Aperçu image actuelle --}}
                @if($burger->image_path)
                <div class="mb-4 p-3 bg-gray-50 rounded-xl border border-gray-200 flex items-center gap-4">
                    <img src="{{ $burger->image_path }}" alt="{{ $burger->name }}" class="h-20 w-20 object-cover rounded-lg border border-gray-200">
                    <div>
                        <p class="text-xs font-semibold text-gray-600">Image actuelle</p>
                        <p class="text-xs text-gray-400 mt-1 truncate max-w-xs">{{ $burger->image_path }}</p>
                    </div>
                </div>
                @endif

                <p class="text-xs font-medium text-gray-500 mb-2 uppercase tracking-wider">Nouvelle image (fichier)</p>
                <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-primary hover:bg-red-50 transition-all group">
                    <input type="file" name="image_file" id="image_file" accept="image/*"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        onchange="previewImage(this)">
                    <div id="drop-content">
                        <span class="material-symbols-outlined text-4xl text-gray-300 group-hover:text-primary transition-colors">cloud_upload</span>
                        <p class="text-sm text-gray-500 mt-2">Glissez une image ou <span class="text-primary font-semibold">cliquez pour parcourir</span></p>
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP — max 2 Mo</p>
                    </div>
                    <img id="image-preview" src="" alt="Aperçu" class="hidden max-h-40 mx-auto rounded-lg mt-2 object-cover">
                </div>
                @error('image_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                <div class="flex items-center gap-3 my-4">
                    <div class="flex-1 h-px bg-gray-200"></div>
                    <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">ou</span>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>

                <p class="text-xs font-medium text-gray-500 mb-1 uppercase tracking-wider">URL d'image</p>
                <input type="url" name="image_url"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm"
                    placeholder="https://exemple.com/image.jpg">
                @error('image_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.burgers.index') }}"
                    class="w-full sm:w-auto text-center px-6 py-3 border border-gray-300 rounded-xl text-slate-700 font-medium hover:bg-gray-50 transition text-sm">
                    Annuler
                </a>
                <button type="submit"
                    class="w-full sm:w-auto px-8 py-3 bg-primary text-white rounded-xl font-bold hover:bg-red-700 transition shadow-lg shadow-primary/30 text-sm flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-base">save</span>
                    Mettre à jour
                </button>
            </div>
        </form>

        {{-- Archiver --}}
        <div class="px-4 sm:px-6 pb-6">
            <div class="border-t border-red-100 pt-4 flex flex-wrap items-center gap-4">
                <form id="archive-form" action="{{ route('admin.burgers.destroy', $burger) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
                <button type="button" onclick="openArchiveModal()"
                    class="flex items-center gap-2 text-orange-600 hover:text-orange-800 text-sm font-medium transition">
                    <span class="material-symbols-outlined text-base">archive</span>
                    Archiver ce burger
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modale confirmation archive --}}
<div id="archive-modal"
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     style="display:none!important; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px);">
    <div class="w-full max-w-sm rounded-2xl shadow-2xl p-6 flex flex-col gap-4"
         style="background:var(--admin-card-bg,#fff); border:1px solid var(--admin-card-border,#e5e7eb);">
        <div class="flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(245,158,11,0.12);">
                <span class="material-symbols-outlined" style="color:#f59e0b;font-size:1.375rem;font-variation-settings:'FILL' 1;">archive</span>
            </div>
            <div>
                <p class="font-bold text-base" style="color:var(--admin-text,#111827);">Archiver ce burger&nbsp;?</p>
                <p class="text-sm mt-1" style="color:var(--admin-text-muted,#6b7280);">
                    Le burger sera masqué du kiosque mais restera dans la base. Vous pourrez le restaurer plus tard.
                </p>
            </div>
        </div>
        <div class="flex justify-end gap-3 pt-1">
            <button type="button" onclick="closeArchiveModal()"
                class="px-5 py-2.5 rounded-xl text-sm font-semibold border transition"
                style="border-color:var(--admin-border,#e5e7eb);color:var(--admin-text-muted,#6b7280);"
                onmouseover="this.style.background='var(--admin-content-bg,#f1f5f9)'"
                onmouseout="this.style.background=''">
                Annuler
            </button>
            <button type="button" onclick="document.getElementById('archive-form').submit()"
                class="px-5 py-2.5 rounded-xl text-sm font-bold text-white transition shadow-lg"
                style="background:#f59e0b;"
                onmouseover="this.style.background='#d97706'"
                onmouseout="this.style.background='#f59e0b'">
                Oui, archiver
            </button>
        </div>
    </div>
</div>

<script>
function openArchiveModal() {
    const m = document.getElementById('archive-modal');
    m.style.removeProperty('display');
    m.style.display = 'flex';
}
function closeArchiveModal() {
    document.getElementById('archive-modal').style.display = 'none';
}
document.getElementById('archive-modal').addEventListener('click', function(e) {
    if (e.target === this) closeArchiveModal();
});

function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const dropContent = document.getElementById('drop-content');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            dropContent.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
