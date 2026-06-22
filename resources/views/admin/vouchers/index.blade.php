@extends('layouts.app')

@section('header', 'Vouchers Management')

@section('actions')
    <button class="btn btn-primary shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#generateModal"><i class="bi bi-plus-lg me-2"></i>Generate Voucher</button>
    <a href="{{ route('admin.vouchers.print') }}" class="btn btn-outline-secondary shadow-sm px-4 ms-2"><i class="bi bi-printer me-2"></i>Print Layout</a>
@endsection

@section('content')
<div class="card border-0 bg-white p-4">
    <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
        <div class="col-12 col-md-3">
            <label class="form-label text-muted fw-bold small text-uppercase mb-1">Search Code</label>
            <input type="text" class="form-control form-control-sm" placeholder="Enter code...">
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label text-muted fw-bold small text-uppercase mb-1">Site</label>
            <select class="form-select form-select-sm">
                <option value="">All Sites</option>
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label text-muted fw-bold small text-uppercase mb-1">Status</label>
            <select class="form-select form-select-sm">
                <option value="">All Statuses</option>
                <option value="unused">Unused</option>
                <option value="active">Active</option>
                <option value="used">Used</option>
                <option value="expired">Expired</option>
            </select>
        </div>
        <div class="col-12 col-md-3 d-flex align-items-end">
            <button class="btn btn-dark btn-sm w-100"><i class="bi bi-funnel me-2"></i>Apply Filters</button>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover datatable align-middle mb-0 w-100">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Site</th>
                    <th>Profile</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vouchers as $voucher)
                <tr>
                    <td class="font-monospace fw-bold text-dark">{{ $voucher->voucher_code }}</td>
                    <td><span class="badge bg-light text-dark border">{{ $voucher->site->site_name ?? '-' }}</span></td>
                    <td>{{ $voucher->profile->profile_name ?? 'N/A' }}</td>
                    <td>
                        @php
                            $badgeClass = match($voucher->status) {
                                'active' => 'bg-success bg-opacity-10 text-success',
                                'used' => 'bg-info bg-opacity-10 text-info',
                                'expired' => 'bg-danger bg-opacity-10 text-danger',
                                default => 'bg-secondary bg-opacity-10 text-secondary'
                            };
                        @endphp
                        <span class="badge rounded-pill {{ $badgeClass }} px-3 py-2">
                            {{ ucfirst($voucher->status) }}
                        </span>
                    </td>
                    <td class="text-muted small">{{ $voucher->created_at->format('M d, Y') }}</td>
                    <td class="text-end">
                        <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle" data-bs-toggle="tooltip" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4 d-flex justify-content-end">
        {{ $vouchers->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Generate Voucher Modal -->
<div class="modal fade" id="generateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Generate Vouchers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs nav-fill mb-4" id="voucherTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold text-dark" id="single-tab" data-bs-toggle="tab" data-bs-target="#single" type="button" role="tab">Single Voucher</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold text-dark" id="bulk-tab" data-bs-toggle="tab" data-bs-target="#bulk" type="button" role="tab">Bulk Generate</button>
                    </li>
                </ul>
                <div class="tab-content" id="voucherTabsContent">
                    <!-- Single Voucher -->
                    <div class="tab-pane fade show active" id="single" role="tabpanel">
                        <form action="{{ route('admin.vouchers.store') }}" method="POST">
                            @csrf
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Site</label>
                                    <select name="site_id" class="form-select" required>
                                        <option value="">Select Site</option>
                                        @foreach(\App\Models\Site::all() as $s)
                                            <option value="{{ $s->id }}">{{ $s->site_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Voucher Profile</label>
                                    <select name="profile_id" class="form-select" required>
                                        <option value="">Select Profile</option>
                                        @foreach(\App\Models\VoucherProfile::where('status','active')->get() as $p)
                                            <option value="{{ $p->id }}">{{ $p->profile_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Voucher Profile</label>
                                    <select name="profile_id" class="form-select" required>
                                        <option value="">Select Profile</option>
                                        @foreach(\App\Models\VoucherProfile::where('status','active')->get() as $p)
                                            <option value="{{ $p->id }}">{{ $p->profile_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Voucher Profile</label>
                                    <select name="profile_id" class="form-select" required>
                                        <option value="">Select Profile</option>
                                        @foreach(\App\Models\VoucherProfile::where('status','active')->get() as $p)
                                            <option value="{{ $p->id }}">{{ $p->profile_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Format</label>
                                    <select name="format" class="form-select" required>
                                        <option value="8_chars">8 Chars Alphanumeric</option>
                                        <option value="10_chars">10 Chars Alphanumeric</option>
                                        <option value="numeric">Numbers Only</option>
                                        <option value="alpha">Letters Only</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-uppercase text-muted">Prefix (Optional)</label>
                                    <input type="text" name="prefix" class="form-control" placeholder="e.g. ST-">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold">Generate Single Voucher</button>
                        </form>
                    </div>

                    <!-- Bulk Generate -->
                    <div class="tab-pane fade" id="bulk" role="tabpanel">
                        <form action="{{ route('admin.vouchers.bulk') }}" method="POST">
                            @csrf
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Site</label>
                                    <select name="site_id" class="form-select" required>
                                        <option value="">Select Site</option>
                                        @foreach(\App\Models\Site::all() as $s)
                                            <option value="{{ $s->id }}">{{ $s->site_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Quantity</label>
                                    <input type="number" name="quantity" class="form-control" value="10" min="1" max="1000" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Voucher Profile</label>
                                    <select name="profile_id" class="form-select" required>
                                        <option value="">Select Profile</option>
                                        @foreach(\App\Models\VoucherProfile::where('status','active')->get() as $p)
                                            <option value="{{ $p->id }}">{{ $p->profile_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Format</label>
                                    <select name="format" class="form-select" required>
                                        <option value="8_chars">8 Chars Alphanumeric</option>
                                        <option value="10_chars">10 Chars Alphanumeric</option>
                                        <option value="numeric">Numbers Only</option>
                                        <option value="alpha">Letters Only</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Prefix (Optional)</label>
                                    <input type="text" name="prefix" class="form-control" placeholder="e.g. ST-">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 fw-bold">Bulk Generate</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection