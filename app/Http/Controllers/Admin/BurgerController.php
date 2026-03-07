<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Burger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BurgerController extends Controller
{
    public function index()
    {
        $burgers = Burger::orderBy('name')->paginate(10);
        return view('admin.burgers.index', compact('burgers'));
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
        $burger->update(['is_archived' => true]);
        return redirect()->route('admin.burgers.index')->with('success', 'Burger archivé.');
    }
}
