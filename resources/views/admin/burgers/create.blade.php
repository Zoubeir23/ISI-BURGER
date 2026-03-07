@extends('layouts.admin')
@section('title', 'Nouveau Burger')
@section('header', 'Ajouter un Burger')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-primary to-red-700 px-6 py-4">
            <h2 class="text-white font-bold text-lg flex items-center gap-2">
                <span class="material-symbols-outlined">add_circle</span>
                Nouveau Burger
            </h2>
        </div>

        <form action="{{ route('admin.burgers.store') }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Nom du burger <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm"
                    placeholder="Ex: Big Beef Crunch" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Prix (FCFA) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price') }}" min="0" step="50"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm"
                        placeholder="2500" required>
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Catégorie</label>
                    <input type="text" name="category" value="{{ old('category') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm"
                        placeholder="Boeuf, Poulet, Végétarien...">
                    @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm resize-none"
                    placeholder="Décrivez votre burger...">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Stock initial <span class="text-red-500">*</span></label>
                <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm"
                    required>
                @error('stock_quantity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Zone image --}}
            <div class="border-t border-gray-100 pt-5">
                <p class="text-sm font-semibold text-slate-700 mb-3 flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">image</span>
                    Image du burger
                </p>

                <p class="text-xs font-medium text-gray-500 mb-2 uppercase tracking-wider">Uploader un fichier</p>
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
                <input type="url" name="image_url" value="{{ old('image_url') }}"
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
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<script>
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
