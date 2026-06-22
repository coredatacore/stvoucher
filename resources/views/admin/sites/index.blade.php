@extends('layouts.app')

@section('header', 'Sites Management')

@section('actions')
    <button class="btn btn-primary shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#addSiteModal"><i class="bi bi-plus-lg me-2"></i>Add Site</button>
@endsection

@section('content')
<div class="card border-0 bg-white p-4">
    <div class="table-responsive">
        <table class="table table-hover datatable align-middle mb-0 w-100">
            <thead>
                <tr>
                    <th>Site Name</th>
                    <th>Site Code</th>
                    <th>Location</th>
                    <th>SSID Name</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sites as $site)
                <tr>
                    <td class="fw-bold text-dark">
                        <div class="d-flex align-items-center">
                            <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width:35px;height:35px;">
                                <i class="bi bi-building"></i>
                            </div>
                            {{ $site->site_name }}
                        </div>
                    </td>
                    <td class="font-monospace text-muted">{{ $site->site_code }}</td>
                    <td>{{ $site->location ?? 'N/A' }}</td>
                    <td><span class="badge bg-light text-dark border"><i class="bi bi-wifi me-1"></i>{{ $site->ssid_name ?? 'N/A' }}</span></td>
                    <td>
                        <span class="badge rounded-pill {{ $site->status == 'active' ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }} px-3 py-2">
                            <i class="bi {{ $site->status == 'active' ? 'bi-check-circle' : 'bi-x-circle' }} me-1"></i>{{ ucfirst($site->status) }}
                        </span>
                    </td>
                    <td class="text-end">
                        <form action="{{ route('admin.sites.destroy', $site->id) }}" method="POST" class="d-inline">
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
        {{ $sites->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Add Site Modal -->
<div class="modal fade" id="addSiteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-building me-2 text-danger"></i>Add New Site</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.sites.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Site Name</label>
                        <input type="text" name="site_name" class="form-control" placeholder="Enter site name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Site Code</label>
                        <input type="text" name="site_code" class="form-control" placeholder="Enter site code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Location</label>
                        <input type="text" name="location" class="form-control" placeholder="Enter location">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">SSID Name</label>
                        <input type="text" name="ssid_name" class="form-control" placeholder="Enter SSID name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Status</label>
                        <select name="status" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Add Site</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection