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
            <div class="bg-blue-600 pt-1 px-2 bg-gradient-to-b from-blue-400 to-blue-500 rounded-xl shadow-lg cursor-pointer hover:opacity-95 w-72 h-52 flex flex-col justify-around">
                <div class="self-center">
                    <p>{{ __('Add / Edit Customer Details')}}</p>
                </div>
            </div>
        </a>
        
        <div class="bg-blue-600 pt-1 px-2 bg-gradient-to-b from-indigo-400 to-indigo-500 rounded-xl shadow-lg cursor-pointer hover:opacity-95 w-72 h-52 flex flex-col justify-around">
            <div class="self-center">
                <p>{{ __('Generate Reports')}}</p>
            </div>
        </div>

    </section>

</div>

@endsection

@section('footer')
    @include('partials.footer')
@endsection

