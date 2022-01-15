@extends('layouts.main')

@section('header')
    @include('partials.sidenav', ['selection' => 'corp-actn-bse'])
@endsection

@section('style')
    @livewireStyles
@endsection

@section('content')

    <section class="mt-4 ml-10">

        <livewire:corp-actn-bse />

    </section>

@endsection

@section('other')
    @livewireScripts
@endsection

