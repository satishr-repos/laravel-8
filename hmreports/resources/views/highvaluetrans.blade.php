@extends('layouts.main')

@section('header')
    @include('partials.sidenav', ['selection' => 'high-value-trans'])
@endsection

@section('style')
    @livewireStyles
@endsection

@section('content')

    <section class="mt-4 ml-10">

        <livewire:high-value-trans />

    </section>

@endsection

@section('other')
    @livewireScripts
@endsection

