@extends('layouts.main')

@section('header')
    @include('partials.sidenav', ['selection' => 'pms-bill-ledger'])
@endsection

@section('style')
    @livewireStyles
@endsection

@section('content')

    <section class="mt-4 ml-10">

        <livewire:pms-bill-ledger />

    </section>

@endsection

@section('other')
    @livewireScripts
@endsection

