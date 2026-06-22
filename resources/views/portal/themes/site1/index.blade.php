@extends('layouts.portal')

@section('content')
<div class="bg-blue-900 p-8 rounded-xl shadow-2xl w-full max-w-md text-center text-white border-t-4 border-blue-400">
    <div class="mb-6">
        <div class="mx-auto w-24 h-24 bg-blue-800 rounded-full flex items-center justify-center mb-4 border-4 border-blue-300">
            <span class="text-blue-100 font-bold text-2xl">S1</span>
        </div>
        <h1 class="text-2xl font-bold text-white tracking-wide">SITE 1 WIFI</h1>
        <p class="text-blue-200 text-sm mt-2">Welcome to Site 1. Enter your access code below.</p>
    </div>

    @if($errors->any())
        <div class="bg-red-500 bg-opacity-20 text-red-200 p-3 rounded-lg mb-4 text-sm border border-red-500">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('portal.authenticate') }}" method="POST">
        @csrf
        @foreach($params ?? [] as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach

        <div class="mb-6">
            <input type="text" name="voucher_code" placeholder="Enter Voucher Code" required
                class="w-full px-4 py-3 bg-blue-800 bg-opacity-50 border border-blue-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-white text-center font-mono text-lg uppercase text-white placeholder-blue-300"
                autocomplete="off">
        </div>
        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-400 text-white font-bold py-3 rounded-lg transition shadow-lg transform hover:-translate-y-1">
            CONNECT NOW
        </button>
    </form>
</div>
@endsection