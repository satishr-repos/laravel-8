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
           
                @case('Tangible Assets')
                    <real-estate class="mb-3" v-bind:base-route="{{ json_encode(route('customer.realestate', $customer)) }}">
                    </real-estate>
                    
                    <personal-asset class="mb-3" v-bind:base-route="{{ json_encode(route('customer.personalitem', $customer)) }}">
                    </personal-asset>
                   
                    @break
                
                @case('Financial Assets')

                    <div class="flex justify-between">

                        <div class="flex-grow">
                            <bank-asset class="mb-3" id="bank-asset" v-bind:base-route="{{ json_encode(route('customer.bank', $customer)) }}">
                            </bank-asset>
                            
                            <fixed-asset class="mb-3" id="fixed-asset" v-bind:base-route="{{ json_encode(route('customer.fixedAsset', $customer)) }}">
                            </fixed-asset>
                            
                            <investment-asset class="mb-3" id="investment-asset" v-bind:base-route="{{ json_encode(route('customer.investmentAsset', $customer)) }}">
                            </investment-asset>
                            
                            <retirement-asset class="mb-3" id="retirement-asset" v-bind:base-route="{{ json_encode(route('customer.retirementAsset', $customer)) }}">
                            </retirement-asset>

                        </div>

                        <div class="h-screen bg-gray-50 px-4 mr-4 text-gray-500 font-merriweather text-base">
                            <p class="mb-3 mt-1 font-semibold uppercase">On This Page</p>
                            <ul>
                                <li class="mb-3">
                                    <a class="hover:cursor-pointer hover:underline" href="#bank-asset">Bank</a>
                                </li>
                                <li class="mb-3">
                                    <a class="hover:cursor-pointer hover:underline"  href="#fixed-asset">Fixed</a>
                                </li>
                                <li class="mb-3">
                                    <a class="hover:cursor-pointer hover:underline"  href="#investment-asset">Investment</a>
                                </li>
                                <li class="mb-3">
                                    <a class="hover:cursor-pointer hover:underline" href="#retirement-asset">Retirement</a>
                                </li>
                            </ul>
                        </div>

                    </div>

                
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
                        v-bind:retirement-route="{{ json_encode(route('customer.retirementAsset', $customer)) }}">
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
                    <income-expense-report class="mb-5" id="ie-report" v-bind:route="{{json_encode(route('customer.iereport', $customer)) }}">
                    </income-expense-report>
                    <balance-sheet class="mb-5" id="balance-sheet" v-bind:route="{{json_encode(route('customer.balancesheet', $customer)) }}">
                    </balance-sheet>
                    <goals-report class="mb-5" id="goals-report" v-bind:route="{{ json_encode(route('customer.goalsreport', $customer)) }}">
                    </goals-report>
                    <risk-management class="mb-5" id="risk-mgmt" v-bind:route="{{ json_encode(route('customer.riskmgmt', $customer)) }}">
                    </risk-management>
                    <living-expense class="mb-5" id="living-expense" v-bind:route="{{ json_encode(route('customer.livingexpenses', $customer)) }}">
                    </living-expense>
                    <cash-flow-report class="mb-5" id="cash-flow-report" v-bind:route="{{ json_encode(route('customer.cashflow', $customer)) }}">
                    </cash-flow-report>
                    <epf-report class="mb-5" id="epf-report" v-bind:route="{{ json_encode(route('customer.epfreport', $customer)) }}">
                    </epf-report>

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

var value = localStorage.getItem('assetState');
var open = JSON.parse(value) === true;

window.onload = function() {

    var sb = document.getElementById("sidebar");
    var sbproxy = document.getElementById("sbproxy");
    var width = sb.offsetWidth + 20;
    
    style = "display:block;" + "width:" + width + "px;";
    sbwrapper.setAttribute("style", style );
   
    // width += 10;
    style = "display:block;" + "width:" + width + "px;";
    sbproxy.setAttribute("style", style);

    toggleAsset(open);
    
    // console.log(sbproxy.offsetWidth, sbproxy.clientWidth);
};

window.onunload = function() {
    
    localStorage.setItem('assetState', open);

};

document.getElementById("assets").onclick = function () {

    open = !open;

    // console.log("onClickAssets: ", open);

    toggleAsset(open);
};

function toggleAsset(val) {
    var tangible = document.getElementById("tangible");
    var financial = document.getElementById("financial");
    var clickimg = document.getElementById("clickimg");

    if (val == false){
        tangible.setAttribute("style", "display:none;");
        financial.setAttribute("style", "display:none;");
        clickimg.classList.remove('rotate-180');
        clickimg.classList.add('rotate-0');
    } else {
        tangible.setAttribute("style", "display:block;");
        financial.setAttribute("style", "display:block;");
        clickimg.classList.remove('rotate-0');
        clickimg.classList.add('rotate-180');
    }
}

@endsection