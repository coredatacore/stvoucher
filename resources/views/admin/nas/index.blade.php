@extends('layouts.app')

@section('header', 'NAS / Clients')

@section('actions')
    <button class="btn btn-primary shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#addNasModal"><i class="bi bi-plus-lg me-2"></i>Add NAS</button>
@endsection

@section('content')
<div class="card border-0 bg-white p-4">
    <div class="table-responsive">
        <table class="table table-hover datatable align-middle mb-0 w-100">
            <thead>
                <tr>
                    <th>NAS Name (IP)</th>
                    <th>Shortname</th>
                    <th>Type</th>
                    <th>Secret</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nas as $n)
                <tr>
                    <td class="fw-bold text-dark">
                        <div class="d-flex align-items-center">
                            <div class="bg-dark bg-opacity-10 text-dark rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width:35px;height:35px;">
                                <i class="bi bi-hdd-network"></i>
                            </div>
                            <span class="font-monospace">{{ $n->nasname }}</span>
                        </div>
                    </td>
                    <td>{{ $n->shortname }}</td>
                    <td><span class="badge bg-light text-dark border">{{ $n->type }}</span></td>
                    <td class="text-muted"><i class="bi bi-key me-1"></i>******</td>
                    <td class="text-end">
                        <form action="{{ route('admin.nas.destroy', $n->id) }}" method="POST" class="d-inline">
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
        {{ $nas->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Add NAS Modal -->
<div class="modal fade" id="addNasModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-hdd-network me-2 text-danger"></i>Add NAS Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.nas.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">NAS Name / IP Address</label>
                        <input type="text" name="nasname" class="form-control" placeholder="e.g., 192.168.1.1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Short Name</label>
                        <input type="text" name="shortname" class="form-control" placeholder="e.g., Router-01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Type</label>
                        <select name="type" class="form-select" required>
                            <option value="other">Other</option>
                            <option value="cisco">Cisco</option>
                            <option value="livingston">Livingston</option>
                            <option value="computone">Computone</option>
                            <option value="max40xx">Max40xx</option>
                            <option value="multitech">Multitech</option>
                            <option value="nat">NAT</option>
                            <option value="pathras">Pathras</option>
                            <option value="patton">Patton</option>
                            <option value="portslave">Portslave</option>
                            <option value="tc">TC</option>
                            <option value="usrhiper">USRHiper</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Shared Secret</label>
                        <input type="password" name="secret" class="form-control" placeholder="Enter shared secret" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Add NAS</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection