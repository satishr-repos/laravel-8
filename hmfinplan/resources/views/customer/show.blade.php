@extends('layouts.main')

@section('header')
<div class="flex">
    <div class="flex-shrink-0">
        @include('partials.sidebar')
    </div>

    <div class="flex-grow">
        @include('partials.nav')
    </div>
</div>
@endsection

@section('content')
<div class="flex x-ignore">
    <div class="w-56">
        {{-- ugly hack to offset by sidebar width --}}
    </div>

    <section class="flex-grow">
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
                    <financial-assets 
                        v-bind:bank-route="{{ json_encode(route('customer.bank', $customer)) }}"
                        v-bind:fixed-route="{{ json_encode(route('customer.fixedAsset', $customer)) }}"
                        v-bind:invest-route="{{ json_encode(route('customer.investmentAsset', $customer)) }}"
                        v-bind:retirement-route="{{ json_encode(route('customer.retirementAsset', $customer)) }}" >
                    </financial-assets>
                
                    @break

                @case('liabilities')
                    <liability v-bind:base-route="{{ json_encode(route('customer.liability', $customer)) }}" ></liability>

                    @break
                
                @case('incomes')
                    <income 
                        v-bind:salary-route="{{ json_encode(route('customer.salary', $customer)) }}"
                        v-bind:rental-route="{{ json_encode(route('customer.rental', $customer)) }}"
                        v-bind:pension-route="{{ json_encode(route('customer.pension', $customer)) }}"
                        v-bind:other-route="{{ json_encode(route('customer.other', $customer)) }}">
                    </income>

                    @break
                
                @case('expenses')
                    <expense v-bind:route="{{ json_encode(route('customer.expense', $customer)) }}">
                    </expense>
                    @break

                @case('insurances')
                    <insurance v-bind:route="{{ json_encode(route('customer.insurance', $customer)) }}">
                    </insurance>
                    @break
                
                @case('goals')
                    <goal v-bind:route="{{ json_encode(route('customer.goal', $customer)) }}">
                    </goal>
                    @break
                
                @case('risks')
                    <risk-tolerance v-bind:route="{{ json_encode(route('customer.risk', $customer)) }}">
                    </risk-tolerance>
                    @break

                @default
                    
            @endswitch
        </div>
    </section>
</div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

