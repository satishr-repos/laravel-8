@extends('layouts.main')

@section('header')
    @include('partials.sidenav', ['selection' => 'corp-actn-nse'])
@endsection

@section('style')
    @livewireStyles
@endsection

@section('content')

    <section class="mt-4 ml-10">

        <livewire:corp-actn-nse />

    </section>

@endsection

@section('other')
    @livewireScripts
@endsection

