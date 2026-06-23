<?php

namespace App\Services;

use App\Models\MikrotikLog;
use App\Models\RouterServer;
use App\Models\Voucher;
use Exception;

class MikroTikService
{
    protected RouterServer $routerServer;
    protected $socket;
    protected bool $connected = false;

    public function __construct(RouterServer $routerServer)
    {
        $this->routerServer = $routerServer;
    }

    public function connect(): bool
    {
        $host = $this->routerServer->ip_address;
        $port = $this->routerServer->api_port;
        $timeout = 5;

        try {
            $this->socket = @fsockopen($host, $port, $errno, $errstr, $timeout);

            if (!$this->socket) {
                $this->log('connect', ['host' => $host, 'port' => $port], ['error' => "Connection failed: $errstr ($errno)"], 'failed');
                return false;
            }

            // Step 1: First /login to get challenge
            $this->send('/login');
            $response = $this->read();

            // Check if any sentence is a trap
            foreach ($response as $sentence) {
                if (isset($sentence['type']) && $sentence['type'] === '!trap') {
                    $this->log('connect', ['host' => $host, 'port' => $port], $response, 'failed');
                    return false;
                }
            }

            // Step 2: Authenticate with username/password
            $this->send('/login', [
                'name' => $this->routerServer->api_username,
                'password' => $this->routerServer->api_password,
            ]);

            $authResponse = $this->read();

            foreach ($authResponse as $sentence) {
                if (isset($sentence['type']) && $sentence['type'] === '!trap') {
                    $this->log('connect', ['host' => $host, 'port' => $port, 'username' => $this->routerServer->api_username], $authResponse, 'failed');
                    return false;
                }
            }

            $this->connected = true;
            $this->log('connect', ['host' => $host, 'port' => $port], $authResponse, 'success');

            // Only save if router server is actually persisted in database
            if ($this->routerServer->exists) {
                $this->routerServer->last_connected_at = now();
                $this->routerServer->last_error = null;
                $this->routerServer->save();
            }

            return true;
        } catch (Exception $e) {
            $this->log('connect', ['host' => $host, 'port' => $port], ['exception' => $e->getMessage()], 'failed');
            return false;
        }
    }

    public function disconnect(): void
    {
        if ($this->socket) {
            fclose($this->socket);
            $this->connected = false;
        }
    }

    public function isConnected(): bool
    {
        return $this->connected;
    }

    protected function send(string $command, array $params = []): void
    {
        $this->writeWord($command);
        foreach ($params as $key => $value) {
            if (strpos($key, '?') === 0) {
                $this->writeWord("$key=$value");
            } else {
                $this->writeWord("=$key=$value");
            }
        }
        $this->writeWord('');
    }

    protected function writeWord(string $word): void
    {
        $length = strlen($word);
        if ($length < 0x80) {
            fwrite($this->socket, chr($length));
        } elseif ($length < 0x4000) {
            $length |= 0x8000;
            fwrite($this->socket, chr(($length >> 8) & 0xFF));
            fwrite($this->socket, chr($length & 0xFF));
        } elseif ($length < 0x200000) {
            $length |= 0xC00000;
            fwrite($this->socket, chr(($length >> 16) & 0xFF));
            fwrite($this->socket, chr(($length >> 8) & 0xFF));
            fwrite($this->socket, chr($length & 0xFF));
        } elseif ($length < 0x10000000) {
            $length |= 0xE0000000;
            fwrite($this->socket, chr(($length >> 24) & 0xFF));
            fwrite($this->socket, chr(($length >> 16) & 0xFF));
            fwrite($this->socket, chr(($length >> 8) & 0xFF));
            fwrite($this->socket, chr($length & 0xFF));
        } else {
            fwrite($this->socket, chr(0xF0));
            fwrite($this->socket, chr(($length >> 24) & 0xFF));
            fwrite($this->socket, chr(($length >> 16) & 0xFF));
            fwrite($this->socket, chr(($length >> 8) & 0xFF));
            fwrite($this->socket, chr($length & 0xFF));
        }
        if ($length > 0) {
            fwrite($this->socket, $word);
        }
    }

    protected function read(): array
    {
        $response = [];
        $sentences = [];
        $currentSentence = [];

        while (true) {
            $word = $this->readWord();
            if ($word === '') {
                if (!empty($currentSentence)) {
                    $sentences[] = $currentSentence;
                }
                break;
            }

            if (strpos($word, '!') === 0) {
                if (!empty($currentSentence)) {
                    $sentences[] = $currentSentence;
                }
                $currentSentence = ['type' => $word];
            } else if (strpos($word, '=') === 0) {
                $parts = explode('=', substr($word, 1), 2);
                if (count($parts) === 2) {
                    $currentSentence[$parts[0]] = $parts[1];
                }
            }
        }

        return $sentences;
    }

    protected function readWord(): string
    {
        $length = ord(fread($this->socket, 1));
        if ($length & 0x80) {
            if (($length & 0xC0) === 0xC0) {
                if (($length & 0xE0) === 0xE0) {
                    if (($length & 0xF0) === 0xF0) {
                        $length &= 0x0F;
                        $length = ($length << 24) | (ord(fread($this->socket, 1)) << 16) | (ord(fread($this->socket, 1)) << 8) | ord(fread($this->socket, 1));
                    } else {
                        $length &= 0x1F;
                        $length = ($length << 16) | (ord(fread($this->socket, 1)) << 8) | ord(fread($this->socket, 1));
                    }
                } else {
                    $length &= 0x3F;
                    $length = ($length << 8) | ord(fread($this->socket, 1));
                }
            } else {
                $length &= 0x7F;
                $length = ($length << 8) | ord(fread($this->socket, 1));
            }
        }

        if ($length === 0) {
            return '';
        }
        return fread($this->socket, $length);
    }

    public function getIdentity(): array
    {
        if (!$this->isConnected()) {
            if (!$this->connect()) {
                throw new Exception('Failed to connect to MikroTik');
            }
        }

        $this->send('/system/identity/print');
        $response = $this->read();

        // Check for trap
        $hasError = false;
        foreach ($response as $sentence) {
            if (isset($sentence['type']) && $sentence['type'] === '!trap') {
                $hasError = true;
                break;
            }
        }
        $this->log('get_identity', [], $response, $hasError ? 'failed' : 'success');

        if ($hasError) {
            throw new Exception('Failed to get identity: ' . json_encode($response));
        }

        // Return the first non-trap sentence
        foreach ($response as $sentence) {
            if (!isset($sentence['type']) || $sentence['type'] !== '!trap') {
                return $sentence;
            }
        }

        return [];
    }

    public function getVersion(): array
    {
        if (!$this->isConnected()) {
            if (!$this->connect()) {
                throw new Exception('Failed to connect to MikroTik');
            }
        }

        $this->send('/system/resource/print');
        $response = $this->read();

        $hasError = false;
        foreach ($response as $sentence) {
            if (isset($sentence['type']) && $sentence['type'] === '!trap') {
                $hasError = true;
                break;
            }
        }
        $this->log('get_version', [], $response, $hasError ? 'failed' : 'success');

        if ($hasError) {
            throw new Exception('Failed to get version: ' . json_encode($response));
        }

        foreach ($response as $sentence) {
            if (!isset($sentence['type']) || $sentence['type'] !== '!trap') {
                return $sentence;
            }
        }

        return [];
    }

    public function getHotspotUserCount(): int
    {
        if (!$this->isConnected()) {
            if (!$this->connect()) {
                throw new Exception('Failed to connect to MikroTik');
            }
        }

        $this->send('/ip/hotspot/user/print', ['count-only' => '']);
        $response = $this->read();

        $hasError = false;
        foreach ($response as $sentence) {
            if (isset($sentence['type']) && $sentence['type'] === '!trap') {
                $hasError = true;
                break;
            }
        }
        $this->log('get_hotspot_user_count', [], $response, $hasError ? 'failed' : 'success');

        if ($hasError) {
            throw new Exception('Failed to get hotspot user count: ' . json_encode($response));
        }

        foreach ($response as $sentence) {
            if (isset($sentence['ret'])) {
                return (int)$sentence['ret'];
            }
        }

        return 0;
    }

    public function addHotspotUser(Voucher $voucher): array
    {
        if (!$this->isConnected()) {
            if (!$this->connect()) {
                throw new Exception('Failed to connect to MikroTik');
            }
        }

        $profile = $voucher->plan ? $voucher->plan->name : 'default';
        $params = [
            'name' => $voucher->username,
            'password' => $voucher->password,
            'profile' => $profile,
        ];

        // If plan has speed limits, add rate limit (format: rx/tx (download/upload)
        if ($voucher->plan) {
            $downloadMbps = $voucher->plan->download_speed_mbps;
            $uploadMbps = $voucher->plan->upload_speed_mbps;
            $downloadKbps = $downloadMbps ? $downloadMbps * 1000 : null;
            $uploadKbps = $uploadMbps ? $uploadMbps * 1000 : null;
            $rateLimit = null;
            
            if ($downloadKbps && $uploadKbps) {
                $rateLimit = $downloadKbps . 'k/' . $uploadKbps . 'k';
            } elseif ($downloadKbps) {
                $rateLimit = $downloadKbps . 'k';
            } elseif ($uploadKbps) {
                $rateLimit = $uploadKbps . 'k';
            }
            
            if ($rateLimit) {
                $params['rate-limit'] = $rateLimit;
            }
        }

        $this->send('/ip/hotspot/user/add', $params);
        $response = $this->read();

        $hasError = false;
        foreach ($response as $sentence) {
            if (isset($sentence['type']) && $sentence['type'] === '!trap') {
                $hasError = true;
                break;
            }
        }
        $this->log('add_hotspot_user', $params, $response, $hasError ? 'failed' : 'success');

        if ($hasError) {
            throw new Exception('Failed to add hotspot user: ' . json_encode($response));
        }

        $userId = null;
        foreach ($response as $sentence) {
            if (isset($sentence['ret'])) {
                $userId = $sentence['ret'];
                break;
            }
        }

        return ['user_id' => $userId, 'response' => $response];
    }

    public function verifyHotspotUserExists(string $username): array
    {
        if (!$this->isConnected()) {
            if (!$this->connect()) {
                throw new Exception('Failed to connect to MikroTik');
            }
        }

        $this->send('/ip/hotspot/user/print', ['?name' => $username]);
        $response = $this->read();

        $hasError = false;
        foreach ($response as $sentence) {
            if (isset($sentence['type']) && $sentence['type'] === '!trap') {
                $hasError = true;
                break;
            }
        }
        $this->log('verify_hotspot_user', ['username' => $username], $response, $hasError ? 'failed' : 'success');

        if ($hasError) {
            throw new Exception('Failed to verify hotspot user: ' . json_encode($response));
        }

        foreach ($response as $sentence) {
            if (isset($sentence['name']) && $sentence['name'] === $username) {
                return ['exists' => true, 'user' => $sentence];
            }
        }

        return ['exists' => false, 'response' => $response];
    }

    public function removeHotspotUser(Voucher $voucher): bool
    {
        if (!$this->isConnected()) {
            if (!$this->connect()) {
                return false;
            }
        }

        try {
            // First find the user
            $verifyResult = $this->verifyHotspotUserExists($voucher->username);

            if (!$verifyResult['exists']) {
                return true;
            }

            $userId = $verifyResult['user']['.id'] ?? null;

            if ($userId) {
                $this->send('/ip/hotspot/user/remove', ['numbers' => $userId]);
                $response = $this->read();

                // Check for trap
                $hasError = false;
                foreach ($response as $sentence) {
                    if (isset($sentence['type']) && $sentence['type'] === '!trap') {
                        $hasError = true;
                        break;
                    }
                }

                $this->log('remove_hotspot_user', ['username' => $voucher->username, 'id' => $userId], $response, $hasError ? 'failed' : 'success');

                if ($hasError) {
                    return false;
                }
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    protected function log(string $action, array $request, array $response, string $status): void
    {
        MikrotikLog::create([
            'action' => $action,
            'request_payload' => $request,
            'response_payload' => $response,
            'status' => $status,
        ]);
    }
}
