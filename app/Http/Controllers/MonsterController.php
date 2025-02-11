<?php

namespace App\Http\Controllers;

use App\Models\Monster;
use App\Models\Rarety;
use App\Models\MonsterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MonsterController extends Controller
{
    public function index()
    {
        $monsters = Monster::with(['type', 'rarety'])
            ->orderBy('created_at', 'desc')
            ->paginate(9); 

        return view('monsters.monsters', compact('monsters'));
    }
    public function show(int $id)
    {
        $monster = Monster::with(['type', 'rarety'])->findOrFail($id);

        return view('monsters.show', compact('monster'));
    }
    public function create()
    {
        $rareties = Rarety::all();
        $monsterTypes = MonsterType::all();

        return view('monsters.create', compact('rareties', 'monsterTypes'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'pv' => 'required|integer',
                'attack' => 'required|integer',
                'defense' => 'required|integer',
                'description' => 'required|string',
                'image_url' => 'required|image',
                'type_id' => 'required|exists:monster_types,id',
                'rarety_id' => 'required|exists:rareties,id',
            ]);

            if ($request->hasFile('image_url')) {
                $file = $request->file('image_url');

                // Générer un nom unique : {timestamp}_{slug-du-nom}.{extension}
                $timestamp  = now()->timestamp;
                $extension  = $file->getClientOriginalExtension();
                $slugName   = Str::slug($validatedData['name']);
                $imageName  = $timestamp . '_' . $slugName . '.' . $extension;


                $file->storeAs('public/images', $imageName);
                $validatedData['image_url'] = $imageName;
                
            }

            $rarety = rarety::findOrFail($validatedData['rarety_id']);
            $validatedData['rarety'] = $rarety->name;

            $validatedData['user_id'] = now()->timestamp;

            Monster::create($validatedData);

            return redirect()->route('monsters.index');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()]);
        }
    }

    public function delete(int $id)
    {
        $monster = Monster::findOrFail($id);

        if ($monster->image_url) {
            Storage::delete('public/images/' . $monster->image_url);
        }

        $monster->delete();

        return redirect()->route('monsters.index');
    }

    public function edit(int $id)
    {
        $monster = Monster::findOrFail($id);

        $rareties = Rarety::all();
        $monsterTypes = MonsterType::all();

        return view('monsters.edit', compact('monster', 'rareties', 'monsterTypes'));
    }


    public function update(Request $request, int $id)
    {
        try {
            $monster = Monster::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'pv' => 'required|integer',
                'attack' => 'required|integer',
                'defense' => 'required|integer',
                'description' => 'required|string',
                'image_url' => 'nullable|image',
                'type_id' => 'required|exists:monster_types,id',
                'rarety_id' => 'required|exists:rareties,id',
            ]);

            if ($request->hasFile('image_url')) {
                if ($monster->image_url) {
                    Storage::delete('public/images/' . $monster->image_url);
                }

                $file = $request->file('image_url');
                $timestamp  = now()->timestamp;
                $extension  = $file->getClientOriginalExtension();
                $slugName   = Str::slug($validatedData['name']);
                $imageName  = $timestamp . '_' . $slugName . '.' . $extension;

                $file->storeAs('public/images', $imageName);

                $validatedData['image_url'] = $imageName;
            } else {
                unset($validatedData['image_url']);
            }

            // 4) Mettre à jour le champ 'rarety' (lecture via l'ID)
            $rarety = Rarety::findOrFail($validatedData['rarety_id']);
            $validatedData['rarety'] = $rarety->name;

            // 5) Mettre à jour le monstre en base
            $monster->update($validatedData);

            // 6) Rediriger
            return redirect()->route('monster.show', [
                'id'   => $monster->id,
                'slug' => Str::slug($monster->name)
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()]);
        }
    }

}
