<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Vouchers</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        @media print {
            body { background: white; }
            .no-print { display: none !important; }
            .page-break { page-break-after: always; }
        }
        .voucher-card {
            border: 2px solid #000;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            background: #fff;
        }
        .voucher-header {
            background-color: #dc3545;
            height: 6px;
            width: 100%;
        }
    </style>
</head>
<body class="p-4 p-md-5">
    <div class="no-print mb-5 bg-white p-4 rounded-3 shadow-sm border d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">Print Vouchers</h4>
            <p class="text-muted small mb-0">Select filters before printing</p>
        </div>
        <div class="d-flex gap-3">
            <select class="form-select form-select-sm w-auto"><option>All Sites</option></select>
            <select class="form-select form-select-sm w-auto"><option>Unused Only</option></select>
            <button onclick="window.print()" class="btn btn-danger fw-bold shadow-sm px-4"><i class="bi bi-printer me-2"></i>Print Now</button>
        </div>
    </div>

    <div class="container-fluid max-w-4xl mx-auto bg-white p-4 p-md-5 shadow-sm rounded-3">
        <div class="row g-4">
            @foreach($vouchers as $index => $voucher)
                <div class="col-6 col-md-4">
                    <div class="voucher-card p-3 text-center">
                        <div class="voucher-header position-absolute top-0 start-0"></div>
                        
                        <h6 class="fw-bold mt-2 mb-1 text-dark">ST Voucher Solution</h6>
                        
                        <div class="d-flex justify-content-between text-muted mb-2 px-1" style="font-size: 0.65rem;">
                            <span>{{ $voucher->site->site_name ?? 'Global' }}</span>
                            <span>{{ $voucher->site->ssid_name ?? 'WiFi' }}</span>
                        </div>

                        <p class="mb-3 border-bottom pb-2" style="font-size: 0.7rem; color: #495057;">
                            {{ $voucher->profile->profile_name ?? 'Custom Profile' }}
                        </p>
                        
                        <div class="bg-light py-2 mb-3 rounded border">
                            <span class="font-monospace fw-bold fs-5 tracking-widest text-dark">{{ $voucher->voucher_code }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between fw-bold text-dark px-2 mb-2" style="font-size: 0.75rem;">
                            <span>₱{{ number_format($voucher->price, 2) }}</span>
                            <span>{{ floor($voucher->duration_seconds / 3600) }} Hrs</span>
                        </div>

                        <div class="text-muted mt-2" style="font-size: 0.6rem;">
                            Connect to the WiFi and enter the voucher code in the portal.
                        </div>
                    </div>
                </div>

                @if(($index + 1) % 15 == 0)
                    </div><div class="page-break"></div><div class="row g-4 mt-4">
                @endif
            @endforeach
        </div>
    </div>
</body>
</html>