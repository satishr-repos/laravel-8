@extends('layouts.main')

@section('header')
<div class="grid grid-cols-5">
    <div class="col-span-1">
        @include('partials.sidebar')
    </div>

    <div class="col-span-4">
        @include('partials.nav')
    </div>
</div>
@endsection

@section('content')
<div class="grid grid-cols-5">
    <div class="col-span-1">

    </div>

    <section class="col-span-4">
        <nav class="bg-grey-light rounded font-sans w-full mt-2 mb-5">
            <ol class="list-reset flex text-grey-dark">
              <li><a href="{{ route('home') }}" class="font-bold">Home</a></li>
              <li><span class="mx-2">/</span></li>
              <li><a href="{{ route('customers') }}" class="font-bold">Customers</a></li>
              <li><span class="mx-2">/</span></li>
              <li>{{ $current }}</li>
            </ol>
        </nav>

        <div id="app">
            @switch($current)
                @case('dashboard')
                    <customer-dashboard></customer-dashboard>
                    @break
                
                @case('personal')
                    {{-- {{ $personalDetails }} --}}
                    <personal-details v-bind:base-route="{{ json_encode(route('customer.personal', $customer)) }}"></personal-details>
                    @break
            
                @default
                    
            @endswitch
        </div>
    </section>
</div>
@endsection

@section('footer')
<div class="grid grid-cols-5">
    <div class="col-span-1">

    </div>

    <div class="col-span-4">
        @include('partials.footer')
    </div>
</div>
@endsection

