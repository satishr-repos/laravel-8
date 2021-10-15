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
        
        <div class="pt-1 px-2 bg-gradient-to-b from-indigo-300 to-indigo-500 rounded-xl shadow-lg cursor-pointer hover:shadow-xl hover:from-indigo-500 hover:to-indigo-900 w-48 h-72 flex flex-col justify-center">
            <div class="self-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M12 22c3.976 0 8-1.374 8-4V6c0-2.626-4.024-4-8-4S4 3.374 4 6v12c0 2.626 4.024 4 8 4zm0-2c-3.722 0-6-1.295-6-2v-1.268C7.541 17.57 9.777 18 12 18s4.459-.43 6-1.268V18c0 .705-2.278 2-6 2zm0-16c3.722 0 6 1.295 6 2s-2.278 2-6 2-6-1.295-6-2 2.278-2 6-2zM6 8.732C7.541 9.57 9.777 10 12 10s4.459-.43 6-1.268V10c0 .705-2.278 2-6 2s-6-1.295-6-2V8.732zm0 4C7.541 13.57 9.777 14 12 14s4.459-.43 6-1.268V14c0 .705-2.278 2-6 2s-6-1.295-6-2v-1.268z"></path>
                </svg>
            </div>
            <div class="self-center">
                <p>{{ __('FIFO Capital Gain')}}</p>
            </div>
            <div class="self-center">
                <p>{{ __('Report')}}</p>
            </div>
        </div>
        
        <div class="pt-1 px-2 bg-gradient-to-b from-green-300 to-green-500 rounded-xl shadow-lg cursor-pointer hover:shadow-xl hover:from-green-600 hover:to-green-900 w-48 h-72 flex flex-col justify-center">
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
        </div>

    </section>

</div>

@endsection

@section('footer')
    @include('partials.footer')
@endsection

