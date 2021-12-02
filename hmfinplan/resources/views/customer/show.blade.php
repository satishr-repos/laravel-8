@extends('layouts.main')

@section('header')
<div class="flex">
    <div class="flex-shrink-0 w-56" id="sbwrapper">
        @include('partials.sidebar')
    </div>

    <div class="flex-grow">
        @include('partials.nav')
    </div>
</div>
@endsection

@section('content')
<div class="flex">
    <div class="w-56" id="sbproxy">
        {{-- ugly hack to offset by sidebar width --}}
    </div>

    <section class="flex-grow" x-ignore>
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
           
                @case('Assets')

                    <asset-sidebar
                        v-bind:re-route="{{json_encode(route('customer.realestate', $customer)) }}"
                        v-bind:pa-route="{{json_encode(route('customer.personalitem', $customer)) }}"
                        v-bind:ba-route="{{json_encode(route('customer.bank', $customer)) }}"
                        v-bind:fi-route="{{json_encode(route('customer.fixedAsset', $customer)) }}"
                        v-bind:ia-route="{{json_encode(route('customer.investmentAsset', $customer)) }}"
                        v-bind:ra-route="{{json_encode(route('customer.retirementAsset', $customer)) }}">
                    </asset-sidebar>

                    @break

                @case('liabilities')
                    <liability v-bind:base-route="{{ json_encode(route('customer.liability', $customer)) }}" ></liability>

                    @break
                
                @case('incomes')
                    <income 
                        v-bind:salary-route="{{ json_encode(route('customer.salary', $customer)) }}"
                        v-bind:rental-route="{{ json_encode(route('customer.rental', $customer)) }}"
                        v-bind:pension-route="{{ json_encode(route('customer.pension', $customer)) }}"
                        v-bind:other-route="{{ json_encode(route('customer.other', $customer)) }}"
                        v-bind:retirement-route="{{ json_encode(route('customer.retirementAsset', $customer)) }}"
                        v-bind:family-route="{{ json_encode(route('customer.family', $customer)) }}">
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

                @case('Financial Plan')
                    <fin-sidebar
                        v-bind:ie-route="{{json_encode(route('customer.iereport', $customer)) }}"
                        v-bind:bs-route="{{json_encode(route('customer.balancesheet', $customer)) }}"
                        v-bind:gl-route="{{json_encode(route('customer.goalsreport', $customer)) }}"
                        v-bind:rk-route="{{json_encode(route('customer.riskmgmt', $customer)) }}"
                        v-bind:le-route="{{json_encode(route('customer.livingexpenses', $customer)) }}"
                        v-bind:cf-route="{{json_encode(route('customer.cashflow', $customer)) }}"
                        v-bind:pf-route="{{json_encode(route('customer.epfreport', $customer)) }}"
                        v-bind:dl-route="{{json_encode(route('customer.xlsreport', $customer)) }}"
                        v-bind:rn-route="{{json_encode(route('customer.recommendation', $customer)) }}">
                    </fin-sidebar>

                    @break;

                @default

                    @break

            @endswitch
        </div>
    </section>
</div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

@section('script')
window.onload = function() {
    
    var sb = document.getElementById("sidebar");
    var sbproxy = document.getElementById("sbproxy");
    var width = sb.offsetWidth + 20;
    
    style = "display:block;" + "width:" + width + "px;";
    sbwrapper.setAttribute("style", style );
    
    // width += 10;
    style = "display:block;" + "width:" + width + "px;";
    sbproxy.setAttribute("style", style);
    
    // console.log(sbproxy.offsetWidth, sbproxy.clientWidth);
};
@endsection