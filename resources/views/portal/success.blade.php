@extends('layouts.portal')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md text-center border-t-4 border-green-500">
    <div class="mb-6">
        <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Connected Successfully</h1>
        <p class="text-gray-500 text-sm mt-2">You now have internet access.</p>
    </div>

    <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
        <p class="text-sm text-gray-600 mb-1">Voucher Code: <span class="font-mono font-bold text-black float-right">{{ $voucher->voucher_code }}</span></p>
        <p class="text-sm text-gray-600">Remaining Time: <span class="font-bold text-black float-right">{{ floor($voucher->duration_seconds / 60) }} Mins</span></p>
    </div>

    <a href="https://google.com" class="block w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg transition shadow-md">
        Continue Browsing
    </a>
</div>
@endsection