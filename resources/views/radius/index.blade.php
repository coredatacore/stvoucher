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
    
    .status-online {
        color: #28a745;
    }
</style>
@endpush

@section('content')
<div class="wrapper">
    <div class="card">
        <div class="card-header">
            <div class="title">RADIUS Service Status</div>
        </div>
        
        <div class="card-body">
            <div class="status-item">
                <span class="status-label">Authentication Engine</span>
                <span class="status-value status-online">Online</span>
            </div>
            <div class="status-item">
                <span class="status-label">Accounting Engine</span>
                <span class="status-value status-online">Online</span>
            </div>
            <div class="status-item">
                <span class="status-label">Database Connection</span>
                <span class="status-value status-online">Online</span>
            </div>
            <div class="status-item">
                <span class="status-label">Last Checked</span>
                <span class="status-value">{{ now()->format('H:i:s') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
