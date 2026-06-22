@extends('layouts.app')

@section('header', 'Settings')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 bg-white p-4">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                
                <h5 class="fw-bold border-bottom pb-3 mb-4"><i class="bi bi-palette me-2 text-danger"></i>Branding</h5>
                
                <div class="mb-4">
                    <label class="form-label fw-bold text-muted small text-uppercase">System Name</label>
                    <input type="text" name="system_name" value="{{ $settings['branding']->where('key', 'system_name')->first()->value ?? '' }}" class="form-control">
                </div>
                
                <div class="mb-5">
                    <label class="form-label fw-bold text-muted small text-uppercase">Primary Color</label>
                    <input type="color" name="primary_color" value="{{ $settings['branding']->where('key', 'primary_color')->first()->value ?? '#dc2626' }}" class="form-control form-control-color w-25" title="Choose your color">
                </div>

                <h5 class="fw-bold border-bottom pb-3 mb-4 mt-5"><i class="bi bi-hdd-network me-2 text-danger"></i>Global RADIUS Settings</h5>
                <p class="text-muted small mb-4">Note: The system uses ONE global shared secret for all NAS devices to connect to FreeRADIUS.</p>

                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold text-muted small text-uppercase">RADIUS Server IP</label>
                        <input type="text" name="radius_server_ip" value="{{ $settings['radius']->where('key', 'radius_server_ip')->first()->value ?? '127.0.0.1' }}" class="form-control">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold text-muted small text-uppercase">Global Shared Secret</label>
                        <input type="password" name="global_shared_secret" value="{{ $settings['radius']->where('key', 'global_shared_secret')->first()->value ?? '' }}" placeholder="********" class="form-control">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold text-muted small text-uppercase">Auth Port</label>
                        <input type="number" name="auth_port" value="{{ $settings['radius']->where('key', 'auth_port')->first()->value ?? '1812' }}" class="form-control">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold text-muted small text-uppercase">Accounting Port</label>
                        <input type="number" name="accounting_port" value="{{ $settings['radius']->where('key', 'accounting_port')->first()->value ?? '1813' }}" class="form-control">
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2 mb-5 p-3 bg-light rounded border">
                    <button type="button" class="btn btn-sm btn-outline-dark"><i class="bi bi-shield-check me-2"></i>Test Auth</button>
                    <button type="button" class="btn btn-sm btn-outline-dark"><i class="bi bi-journal-text me-2"></i>Test Acct</button>
                    <button type="button" class="btn btn-sm btn-outline-dark"><i class="bi bi-database me-2"></i>Test DB</button>
                </div>

                <h5 class="fw-bold border-bottom pb-3 mb-4 mt-5"><i class="bi bi-ticket-perforated me-2 text-danger"></i>Voucher Defaults</h5>
                
                <div class="row g-4 mb-5">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold text-muted small text-uppercase">Default Prefix</label>
                        <input type="text" name="default_prefix" value="{{ $settings['voucher']->where('key', 'default_prefix')->first()->value ?? '' }}" class="form-control">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold text-muted small text-uppercase">Default Code Length</label>
                        <input type="number" name="default_length" value="{{ $settings['voucher']->where('key', 'default_length')->first()->value ?? '8' }}" class="form-control">
                    </div>
                </div>

                <div class="d-flex justify-content-end border-top pt-4">
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm">
                        <i class="bi bi-save me-2"></i>Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection