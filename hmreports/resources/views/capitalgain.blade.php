@extends('layouts.main')

@section('header')
    @include('partials.sidenav', ['selection' => 'capital-gain'])
@endsection

@section('style')
    @livewireStyles
@endsection

@section('content')

    <section class="mt-4 ml-10">

        <livewire:capital-gain />

    </section>

@endsection

@section('other')
    @livewireScripts
@endsection

