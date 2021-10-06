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
            <div class="pt-1 px-2 bg-gradient-to-b from-blue-300 to-blue-500 rounded-xl shadow-lg cursor-pointer hover:shadow-xl hover:from-blue-600 hover:to-blue-900 w-48 h-72 flex flex-col justify-around">
                <div class="self-center">
                    <p>{{ __('Customer Financial Plan Software')}}</p>
                </div>
            </div>
        </a>
        
        <div class="pt-1 px-2 bg-gradient-to-b from-indigo-300 to-indigo-500 rounded-xl shadow-lg cursor-pointer hover:shadow-xl hover:from-indigo-500 hover:to-indigo-900 w-48 h-72 flex flex-col justify-around">
            <div class="self-center">
                <p>{{ __('FIFO Capital Gain Report')}}</p>
            </div>
        </div>
        
        <div class="pt-1 px-2 bg-gradient-to-b from-green-300 to-green-500 rounded-xl shadow-lg cursor-pointer hover:shadow-xl hover:from-green-600 hover:to-green-900 w-48 h-72 flex flex-col justify-around">
            <div class="self-center">
                <p>{{ __('Bill Ledger Computation Report')}}</p>
            </div>
        </div>

    </section>

</div>

@endsection

@section('footer')
    @include('partials.footer')
@endsection

