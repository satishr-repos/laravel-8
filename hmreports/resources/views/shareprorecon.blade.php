@extends('layouts.main')

@section('header')
    @include('partials.sidenav', ['selection' => 'sharepro-recon'])
@endsection

@section('style')
    @livewireStyles
@endsection

@section('content')

    <section class="mt-4 ml-10">

        <livewire:sharepro-recon />

    </section>

@endsection

@section('other')
    @livewireScripts
@endsection

