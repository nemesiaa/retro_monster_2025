@extends('templates.index')

@section('title', 'Éditer le Monstre ' . $monster->name)

@section('content')
<div class="container mx-auto pb-12">
    <div class="flex flex-wrap justify-center">
        <div class="w-full">
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-4 text-center creepster">
                    Éditer le monstre
                </h2>

                @if($errors->any())
                    <div class="bg-red-500 text-white p-4 rounded mb-4">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                  action="{{ route('monster.update', ['id' => $monster->id]) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-6"
                >
                    @csrf
                    @method('PUT')  <!-- On simule la requête PUT -->

                    <!-- Nom -->
                    <div>
                        <label for="name" class="block mb-1">Nom</label>
                        <input
                          type="text"
                          id="name"
                          name="name"
                          class="w-full border rounded px-3 py-2 text-gray-700"
                          value="{{ old('name', $monster->name) }}"
                          required
                        />
                    </div>

                    <!-- PV -->
                    <div>
                        <label for="pv" class="block mb-1">PV</label>
                        <input
                          type="number"
                          id="pv"
                          name="pv"
                          class="w-full border rounded px-3 py-2 text-gray-700"
                          value="{{ old('pv', $monster->pv) }}"
                          required
                        />
                    </div>

                    <!-- Attaque -->
                    <div>
                        <label for="attack" class="block mb-1">Attaque</label>
                        <input
                          type="number"
                          id="attack"
                          name="attack"
                          class="w-full border rounded px-3 py-2 text-gray-700"
                          value="{{ old('attack', $monster->attack) }}"
                          required
                        />
                    </div>

                    <!-- Défense -->
                    <div>
                        <label for="defense" class="block mb-1">Défense</label>
                        <input
                          type="number"
                          id="defense"
                          name="defense"
                          class="w-full border rounded px-3 py-2 text-gray-700"
                          value="{{ old('defense', $monster->defense) }}"
                          required
                        />
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block mb-1">Description</label>
                        <textarea
                          id="description"
                          name="description"
                          class="w-full border rounded px-3 py-2 text-gray-700"
                          required
                        >{{ old('description', $monster->description) }}</textarea>
                    </div>

                    <!-- Image -->
                    <div>
                        <label for="image_url" class="block mb-1">Nouvelle Image (optionnel)</label>
                        <input
                          type="file"
                          id="image_url"
                          name="image_url"
                          class="w-full border rounded px-3 py-2 text-gray-700"
                          onchange="showFileName(event)"
                        />
                        <p id="file-name" class="text-gray-300 text-sm mt-1"></p>
                        @if($monster->image_url)
                          <p class="mt-2 text-gray-400">Image actuelle: {{ $monster->image_url }}</p>
                          <img
                            src="{{ asset('images/' . $monster->image_url) }}"
                            alt="{{ $monster->name }}"
                            class="h-20 mt-2"
                          >
                        @endif
                    </div>

                    <!-- Type de Monstre -->
                    <div>
                        <label for="type_id" class="block mb-1">Type</label>
                        <select
                          id="type_id"
                          name="type_id"
                          class="w-full border rounded px-3 py-2 text-gray-700"
                          required
                        >
                            @foreach($monsterTypes as $type)
                                <option
                                  value="{{ $type->id }}"
                                  {{ $monster->type_id == $type->id ? 'selected' : '' }}
                                >
                                  {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Rareté -->
                    <div>
                        <label for="rarety_id" class="block mb-1">Rareté</label>
                        <select
                          id="rarety_id"
                          name="rarety_id"
                          class="w-full border rounded px-3 py-2 text-gray-700"
                          required
                        >
                            @foreach($rareties as $rarety)
                                <option
                                  value="{{ $rarety->id }}"
                                  {{ $monster->rarety_id == $rarety->id ? 'selected' : '' }}
                                >
                                  {{ $rarety->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-between items-center">
                        <button
                          type="submit"
                          class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                        >
                            Enregistrer
                        </button>
                        <a
                          href="{{ route('monsters.index') }}"
                          class="text-red-400 hover:text-red-500"
                        >
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showFileName(event) {
        const input = event.target;
        const fileName = input.files[0]?.name || "Aucun fichier sélectionné";
        document.getElementById('file-name').innerText = `Fichier sélectionné : ${fileName}`;
    }
</script>
@endsection
