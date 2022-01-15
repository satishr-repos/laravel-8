@extends('layouts.main')

@section('header')
    @include('partials.sidenav', ['selection' => 'tradejini-brokerage'])
@endsection

@section('style')
    @livewireStyles
@endsection

@section('content')

    <section class="mt-4 ml-10">

        <livewire:tradejini-brokerage />

    </section>

@endsection

@section('other')
    @livewireScripts
@endsection

