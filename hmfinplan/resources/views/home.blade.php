@extends('layouts.main')

@section('header')
    @include('partials.nav')
@endsection

@section('content')

<div class="md:h-screen-80">

    <section class="bg-blue-50 py-5 text-center">
        <h2 class="text-2xl font-serif"> {{ __('What do you want to do today ') }} </h2>
        <h5 class="text-sm font-serif"> {{ __('Choose one of the service to continue ') }} </h2>
    </section>

    <section class="pt-10 bg-white h-screen font-serif font-semibold text-white flex flex-col md:flex-row items-center md:items-start justify-evenly">
        <div></div>
        <a class="block" href="{{ route('customers') }}">
            <div class="pt-1 px-2 bg-gradient-to-b from-blue-300 to-blue-500 rounded-xl shadow-lg cursor-pointer hover:shadow-xl hover:from-blue-600 hover:to-blue-900 w-48 h-72 flex flex-col justify-center">
                <div class="self-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M19 2H5c-1.103 0-2 .897-2 2v16c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2zM5 20V4h14l.001 16H5z"></path><path d="M7 12h2v2H7zm0 4h2v2H7zm4-4h2v2h-2zM7 6h10v4H7zm4 10h2v2h-2zm4-4h2v6h-2z"></path></svg>
                </div>
                <div class="self-center">
                    <p>{{ __('Financial Plan')}}</p>
                </div>
                <div class="self-center">
                    <p>{{ __('Software')}}</p>
                </div>
            </div>
        </a>
        
        <a class="block" href="{{ route('tools') }}">
            <div class="pt-1 px-2 bg-gradient-to-b from-green-300 to-green-500 rounded-xl shadow-lg cursor-pointer hover:shadow-xl hover:from-green-600 hover:to-green-900 w-48 h-72 flex flex-col justify-center">
                <div class="self-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M5.122 21c.378.378.88.586 1.414.586S7.572 21.378 7.95 21l4.336-4.336a7.495 7.495 0 0 0 2.217.333 7.446 7.446 0 0 0 5.302-2.195 7.484 7.484 0 0 0 1.632-8.158l-.57-1.388-4.244 4.243-2.121-2.122 4.243-4.243-1.389-.571A7.478 7.478 0 0 0 14.499 2c-2.003 0-3.886.78-5.301 2.196a7.479 7.479 0 0 0-1.862 7.518L3 16.05a2.001 2.001 0 0 0 0 2.828L5.122 21zm4.548-8.791-.254-.616a5.486 5.486 0 0 1 1.196-5.983 5.46 5.46 0 0 1 4.413-1.585l-3.353 3.353 4.949 4.95 3.355-3.355a5.49 5.49 0 0 1-1.587 4.416c-1.55 1.55-3.964 2.027-5.984 1.196l-.615-.255-5.254 5.256h.001l-.001 1v-1l-2.122-2.122 5.256-5.255z"></path></svg>
                </div>
                <div class="self-center">
                    <p>{{ __('Financial Tools')}}</p>
                </div>
                <div class="self-center">
                    <p>{{ __('And Utilities')}}</p>
                </div>
            </div>
        </a>
        
        <!-- <div class="pt-1 px-2 bg-gradient-to-b from-green-300 to-green-500 rounded-xl shadow-lg cursor-pointer hover:shadow-xl hover:from-green-600 hover:to-green-900 w-48 h-72 flex flex-col justify-center">
            <div class="self-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M20 3H4c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zM4 19V5h16l.002 14H4z"></path><path d="M6 7h12v2H6zm0 4h12v2H6zm0 4h6v2H6z"></path>
                </svg>
            </div>
            <div class="self-center">
                <p>{{ __('Bill Ledger')}}</p>
            </div>
            <div class="self-center">
                <p>{{ __('Computation Report')}}</p>
            </div>
        </div> -->

    </section>

</div>

@endsection

@section('footer')
    @include('partials.footer')
@endsection

