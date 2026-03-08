<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Burger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BurgerController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'active');

        $query = Burger::orderBy('name');

        if ($filter === 'archived') {
            $query->where('is_archived', true);
        } else {
            $query->where('is_archived', false);
        }

        $burgers = $query->paginate(10)->appends(['filter' => $filter]);
        $activeCount = Burger::where('is_archived', false)->count();
        $archivedCount = Burger::where('is_archived', true)->count();

        return view('admin.burgers.index', compact('burgers', 'filter', 'activeCount', 'archivedCount'));
    }

    public function create()
    {
        return view('admin.burgers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'image_file'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_url'      => 'nullable|url',
            'description'    => 'nullable|string',
            'category'       => 'nullable|string',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('burgers', 'public');
            $imagePath = Storage::url($path);
        } elseif (!empty($request->image_url)) {
            $imagePath = $request->image_url;
        }

        Burger::create([
            'name'           => $request->name,
            'price'          => $request->price,
            'image_path'     => $imagePath,
            'description'    => $request->description,
            'category'       => $request->category,
            'stock_quantity' => $request->stock_quantity,
        ]);

        return redirect()->route('admin.burgers.index')->with('success', 'Burger ajouté avec succès.');
    }

    public function edit(Burger $burger)
    {
        return view('admin.burgers.edit', compact('burger'));
    }

    public function update(Request $request, Burger $burger)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'image_file'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_url'      => 'nullable|url',
            'description'    => 'nullable|string',
            'category'       => 'nullable|string',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $imagePath = $burger->image_path;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('burgers', 'public');
            $imagePath = Storage::url($path);
        } elseif (!empty($request->image_url)) {
            $imagePath = $request->image_url;
        }

        $burger->update([
            'name'           => $request->name,
            'price'          => $request->price,
            'image_path'     => $imagePath,
            'description'    => $request->description,
            'category'       => $request->category,
            'stock_quantity' => $request->stock_quantity,
        ]);

        return redirect()->route('admin.burgers.index')->with('success', 'Burger mis à jour avec succès.');
    }

    public function destroy(Burger $burger)
    {
        if ($burger->is_archived) {
            $finalStatuses = ['delivered', 'paid', 'cancelled'];

            // Commandes actives qui référencent ce burger
            $activeItems = $burger->orderItems()
                ->whereHas('order', fn($q) => $q->whereNotIn('status', $finalStatuses))
                ->exists();

            if ($activeItems) {
                return redirect()
                    ->route('admin.burgers.index', ['filter' => 'archived'])
                    ->with('error', 'Impossible de supprimer « ' . $burger->name . ' » : des commandes en cours le référencent encore. Attendez qu\'elles soient livrées ou annulées.');
            }

            // Nullifier les références dans les commandes terminées pour préserver l'historique
            $burger->orderItems()->update(['burger_id' => null]);

            $burger->delete();
            return redirect()->route('admin.burgers.index', ['filter' => 'archived'])->with('success', 'Burger supprimé définitivement.');
        }

        // Sinon, archiver
        $burger->update(['is_archived' => true]);
        return redirect()->route('admin.burgers.index')->with('success', 'Burger archivé.');
    }

    public function restore(Burger $burger)
    {
        $burger->update(['is_archived' => false]);
        return redirect()->route('admin.burgers.index')->with('success', 'Burger restauré.');
    }
}
