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

        <section class="col-span-4 h-screen-80">

        
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

