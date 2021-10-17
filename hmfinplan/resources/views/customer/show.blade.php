@extends('layouts.main')

@section('header')
<div class="grid grid-cols-6">
    <div class="col-span-1">
        @include('partials.sidebar')
    </div>

    <div class="col-span-5">
        @include('partials.nav')
    </div>
</div>
@endsection

@section('content')
<div class="grid grid-cols-6">
    <div class="col-span-1">

    </div>

    <section class="col-span-5">
        {{-- breadcrumps --}}
        <nav class="bg-grey-light rounded font-sans w-full mt-2 mb-5">
            <ol class="list-reset flex text-grey-dark">
              <li><a href="{{ route('home') }}" class="font-bold">Home</a></li>
              <li><span class="mx-2">/</span></li>
              <li><a href="{{ route('customers') }}" class="font-bold">Customers</a></li>
              <li><span class="mx-2">/</span></li>
              <li>{{ $current }}</li>
            </ol>
        </nav>

        {{-- vue components --}}
        <div id="app" class="w-auto">
            @switch($current)
                @case('dashboard')
                    <customer-dashboard></customer-dashboard>
                    @break
                
                @case('personal')
                    <personal-detail class="mb-3" v-bind:base-route="{{ json_encode(route('customer.personal', $customer)) }}"></personal-detail>
                    <family-member class="mb-3" v-bind:base-route="{{ json_encode(route('customer.family', $customer)) }}"></family-member>
                    <professional-detail v-bind:base-route="{{ json_encode(route('customer.profession', $customer)) }}"></professional-detail>
                    @break
           
                @case('assets')
                    <tangible-assets class="mb-3" v-bind:real-estate="{{ json_encode(route('customer.realestate', $customer)) }}"
                        v-bind:personal-item="{{json_encode(route('customer.personalitem', $customer)) }}">
                    </tangible-assets>
                    <financial-assets v-bind:bank-route="{{ json_encode(route('customer.bank', $customer)) }}"
                        v-bind:fixed-route="{{json_encode(route('customer.personalitem', $customer)) }}">
                    </financial-assets>
                
                    @break

                @default
                    
            @endswitch
        </div>
    </section>
</div>
@endsection

@section('footer')
<div class="grid grid-cols-6">
    <div class="col-span-1">

    </div>

    <div class="col-span-5">
        @include('partials.footer')
    </div>
</div>
@endsection

