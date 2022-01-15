@extends('layouts.main')

@section('header')
    @include('partials.sidenav', ['selection' => 'orbis-custody-file'])
@endsection

@section('style')
    @livewireStyles
@endsection

@section('content')

    <section class="mt-4 ml-10">

        <livewire:orbis-custody-file />

    </section>

@endsection

@section('other')
    @livewireScripts
@endsection

