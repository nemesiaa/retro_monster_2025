<section class="mb-20">
    <h2 class="text-2xl font-bold mb-4 creepster">
    Derniers monstres ajoutés
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <!-- Monster Item -->
    @foreach($monsters as $monster)
      @include('monsters._index', ['monsters' => $monsters])
      @endforeach
    </div>
</section>