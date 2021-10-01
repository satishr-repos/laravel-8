@extends('layouts.main')

@section('header')
    @include('partials.nav')
@endsection

@section('content')

<div class="">

    <section class="flex justify-center">

        <div id="app">
            <customer-list v-bind:base-route="{{ json_encode(route('customers')) }}"></customer-list>
        </div>
        
    </section>

</div>

@endsection

@section('footer')
    @include('partials.footer')
@endsection

