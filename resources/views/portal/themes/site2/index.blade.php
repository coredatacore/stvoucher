@extends('layouts.portal')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md text-center border border-gray-100">
    <div class="mb-8">
        <div class="mx-auto w-20 h-20 bg-green-50 rounded-2xl flex items-center justify-center mb-6 transform rotate-3">
            <span class="text-green-600 font-black text-3xl">-S2-</span>
        </div>
        <h1 class="text-3xl font-black text-gray-800">Site 2 Access</h1>
        <p class="text-gray-500 text-sm mt-2 font-medium">Fast, secure internet access.</p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-6 text-sm font-semibold">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('portal.authenticate') }}" method="POST">
        @csrf
        @foreach($params ?? [] as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach

        <div class="mb-6 relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>
            <input type="text" name="voucher_code" placeholder="Voucher Code" required
                class="w-full pl-11 pr-4 py-4 bg-gray-50 border-none rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 font-mono text-lg uppercase text-gray-800 font-bold"
                autocomplete="off">
        </div>
        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-xl transition shadow-md">
            GET ONLINE
        </button>
    </form>
</div>
@endsection