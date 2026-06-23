@extends('layouts.app')

@section('header', 'Authentication Logs')

@section('content')
<div class="card border-0 bg-white p-4">
    <div class="table-responsive">
        <table class="table table-hover datatable align-middle mb-0 w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Reply</th>
                    <th>Auth Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr>
                    <td class="text-muted">#{{ $log->id }}</td>
                    <td class="font-monospace fw-bold text-dark">{{ $log->username }}</td>
                    <td>
                        @php
                            $badgeClass = $log->reply == 'Access-Accept' ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger';
                            $iconClass = $log->reply == 'Access-Accept' ? 'bi-check-circle' : 'bi-x-circle';
                        @endphp
                        <span class="badge rounded-pill {{ $badgeClass }} px-3 py-2">
                            <i class="bi {{ $iconClass }} me-1"></i>{{ $log->reply }}
                        </span>
                    </td>
                    <td class="text-muted small"><i class="bi bi-calendar me-1"></i>{{ $log->authdate }}</td>
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