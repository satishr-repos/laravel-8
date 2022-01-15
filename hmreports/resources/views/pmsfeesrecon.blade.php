@extends('layouts.main')

@section('header')
    @include('partials.sidenav', ['selection' => 'pms-fees-recon'])
@endsection

@section('style')
    @livewireStyles
@endsection

@section('content')

    <section class="mt-4 ml-10">

        <livewire:pms-fees-recon />

    </section>

@endsection

@section('other')
    @livewireScripts
@endsection

