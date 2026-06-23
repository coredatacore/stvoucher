@extends('layouts.app')

@section('header', 'Accounting Logs')

@section('content')
<div class="card border-0 bg-white p-4">
    <div class="table-responsive">
        <table class="table table-hover datatable align-middle mb-0 w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Start Time</th>
                    <th>Stop Time</th>
                    <th>Session Time</th>
                    <th>Terminate Cause</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr>
                    <td class="text-muted">#{{ $log->radacctid }}</td>
                    <td class="font-monospace fw-bold text-dark">{{ $log->username }}</td>
                    <td><i class="bi bi-play-circle text-success me-1"></i>{{ $log->acctstarttime }}</td>
                    <td>
                        @if($log->acctstoptime)
                            <i class="bi bi-stop-circle text-danger me-1"></i>{{ $log->acctstoptime }}
                        @else
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill"><i class="bi bi-broadcast me-1"></i>Active</span>
                        @endif
                    </td>
                    <td><span class="badge bg-light text-dark border">{{ gmdate("H:i:s", $log->acctsessiontime) }}</span></td>
                    <td class="small text-muted">{{ $log->acctterminatecause ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4 d-flex justify-content-end">
        {{ $logs->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection