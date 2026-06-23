<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$domains = [
    'panel.stvouchersolutions.xyz',
    'portal.stvouchersolutions.xyz',
    'api.stvouchersolutions.xyz',
    'status.stvouchersolutions.xyz',
    'radius.stvouchersolutions.xyz',
];

foreach ($domains as $domain) {
    $request = Illuminate\Http\Request::create("https://{$domain}/", 'GET');
    $response = $kernel->handle($request);
    echo "Domain: {$domain} -> Status: {$response->getStatusCode()}\n";
    if ($response->isRedirection()) {
        echo "  Redirects to: " . $response->headers->get('Location') . "\n";
    } else {
        echo "  Content snippet: " . substr(str_replace("\n", "", $response->getContent()), 0, 50) . "...\n";
    }
}
