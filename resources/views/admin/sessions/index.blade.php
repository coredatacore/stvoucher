@extends('layouts.app')

@section('header', 'Active Sessions')

@section('content')
<div class="card border-0 bg-white p-4">
    <div class="table-responsive">
        <table class="table table-hover datatable align-middle mb-0 w-100">
            <thead>
                <tr>
                    <th>Username / Voucher</th>
                    <th>IP Address</th>
                    <th>MAC Address</th>
                    <th>Session Time</th>
                    <th>Downloaded</th>
                    <th>Uploaded</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sessions as $session)
                <tr>
                    <td class="font-monospace fw-bold text-dark">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width:35px;height:35px;">
                                <i class="bi bi-person"></i>
                            </div>
                            {{ $session->username }}
                        </div>
                    </td>
                    <td>{{ $session->framedipaddress }}</td>
                    <td class="font-monospace text-muted small">{{ $session->callingstationid }}</td>
                    <td><span class="badge bg-light text-dark border"><i class="bi bi-clock me-1"></i>{{ gmdate("H:i:s", $session->acctsessiontime) }}</span></td>
                    <td class="text-success"><i class="bi bi-arrow-down-circle me-1"></i>{{ round($session->acctoutputoctets / 1048576, 2) }} MB</td>
                    <td class="text-primary"><i class="bi bi-arrow-up-circle me-1"></i>{{ round($session->acctinputoctets / 1048576, 2) }} MB</td>
                    <td class="text-end">
                        <form action="{{ route('admin.sessions.disconnect', $session->username) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" data-bs-toggle="tooltip" title="Disconnect User via CoA">
                                <i class="bi bi-plug me-1"></i>Disconnect
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection