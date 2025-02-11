@extends('templates.index')


@section('title')
    Home
@stop

@section('content')
<!-- Section Monstre Aléatoire -->
    @include('monsters._random', [
        'monster' => \App\Models\Monster::inRandomOrder()->first()
    ])
<!-- Section Derniers monstres -->
    @include('monsters._recents',['monsters'=>\App\Models\Monster::latest()->take(3)->get()])
@stop