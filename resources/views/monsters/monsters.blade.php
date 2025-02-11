@extends('templates.index')

@section('title')
    {{ 'Monstres' }}
@endsection

@section('content')
<h2 class="text-3xl font-bold mb-2 creepster">Listes des monstres :</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($monsters as $monster)
        @include('monsters._index', ['monster' => $monster])
    @endforeach
</div>

<div class="mt-4">
    {{ $monsters->links() }}
</div>
@endsection
