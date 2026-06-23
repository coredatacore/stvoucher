@extends('layouts.portal')

@section('body_class', 'theme-default')

@push('styles')
<style>
    .theme-default {
        background-color: #080000;
        background-image: 
            radial-gradient(ellipse at bottom, rgba(200, 0, 0, 0.4) 0%, transparent 45%),
            radial-gradient(circle at 50% 25%, rgba(200, 0, 0, 0.4) 0%, transparent 60%);
        color: white;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        padding: 0;
    }

    .wrapper {
        width: 100%;
        max-width: 420px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .card {
        width: 100%;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.6), 0 0 20px rgba(200,0,0,0.2);
        overflow: hidden;
        margin-bottom: 20px;
        backdrop-filter: blur(10px);
        background: rgba(15, 15, 15, 0.95);
        transition: all 0.3s ease;
    }

    .card-header {
        background-color: transparent;
        padding: 30px 20px 18px 20px;
        text-align: center;
        border-bottom: 2px solid rgba(204, 0, 0, 0.5);
        position: relative;
    }
    .card-header::after {
        content: '';
        position: absolute;
        bottom: -2px; left: 0; width: 100%; height: 2px;
        background: #cc0000;
        box-shadow: 0 0 10px #cc0000;
    }

    .title {
        font-size: 20px;
        font-weight: bold;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .card-body {
        background-color: #ffffff;
        padding: 25px 20px;
        color: #333;
    }

    .status-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }
    
    .status-item:last-child {
        border-bottom: none;
    }

    .status-label {
        font-weight: 600;
        color: #666;
        font-size: 14px;
    }

    .status-value {
        font-weight: 800;
        color: #cc0000;
        font-size: 14px;
    }

    .btn {
        width: 100%;
        padding: 15px;
        border: none;
        border-radius: 25px;
        font-size: 15px;
        font-weight: 800;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: #cc0000;
        color: white;
        margin-top: 15px;
        box-shadow: 0 4px 15px rgba(204, 0, 0, 0.4);
    }
    .btn:hover {
        background-color: #ff1a1a;
        box-shadow: 0 6px 20px rgba(204, 0, 0, 0.6);
    }
</style>
@endpush

@section('content')
<div class="wrapper">
    <div class="card">
        <div class="card-header">
            <div class="title">Voucher Status</div>
        </div>
        
        <div class="card-body">
            <div class="status-item">
                <span class="status-label">IP Address</span>
                <span class="status-value">{{ request()->ip() }}</span>
            </div>
            <div class="status-item">
                <span class="status-label">Connection</span>
                <span class="status-value" style="color: #28a745;">Active</span>
            </div>
            <div class="status-item">
                <span class="status-label">Remaining Time</span>
                <span class="status-value">--:--:--</span>
            </div>
            
            <button class="btn" onclick="window.location.reload()">REFRESH STATUS</button>
        </div>
    </div>
</div>
@endsection
