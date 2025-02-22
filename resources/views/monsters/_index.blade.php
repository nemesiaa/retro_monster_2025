<article
        class="relative bg-gray-700 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300 monster-card"
        data-monster-type="{{Str::lower($monster->type->name)}}"
    >
        <img
        class="w-full h-48 object-cover rounded-t-lg"
        src="{{asset('images/'.$monster->image_url)}}"
        alt="{{$monster->name}}"
        />
        <div class="p-4">
        <h3 class="text-xl font-bold">{{$monster->name}}</h3>
        <h4 class="mb-2">
            <a href="#" class="text-red-400 hover:underline"
            >{{$monster->user_id}}</a
            >
        </h4>
        <p class="text-gray-300 text-sm mb-2">
            {{$monster->description}}
        </p>
        <div class="flex justify-between items-center mb-2">
            <div>
            <span class="text-yellow-400">★★★★☆</span>
            <span class="text-gray-300 text-sm">(4.0/5.0)</span>
            </div>
            <span class="text-sm text-gray-300">Type: {{$monster->Type->name}}</span>
        </div>
        <div class="flex justify-between items-center mb-4">
            <span class="text-sm text-gray-300">PV: {{$monster->pv}}</span>
            <span class="text-sm text-gray-300">Attaque: {{$monster->attack}}</span>
        </div>
        <div class="text-center">
            <a
            href="{{route('monster.show', ['id'=> $monster->id, 'slug' => Str::slug($monster->name)])}}"
            class="inline-block text-white bg-red-500 hover:bg-red-700 rounded-full px-4 py-2 transition-colors duration-300"
            >Plus de détails</a
            >
        </div>
        </div>
        <div class="absolute top-4 right-4">
        <button
            class="text-white bg-gray-400 hover:bg-red-700 rounded-full p-2 transition-colors duration-300"
            style="
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            "
        >
            <i class="fa fa-bookmark"></i>
        </button>
        </div>
    </article>