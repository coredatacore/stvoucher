<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SystemUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class InstallController extends Controller
{
    public function index(Request $request)
    {
        if (file_exists(storage_path('installed'))) {
            return redirect('/');
        }
        $step = $request->get('step', 1);
        return view("install.step{$step}", compact('step'));
    }

    public function process(Request $request, string $step)
    {
        if (file_exists(storage_path('installed'))) {
            return redirect('/');
        }

        if ($step == 2) {
            // DB Check
            try {
                DB::connection()->getPdo();
            } catch (\Exception $e) {
                return back()->with('error', 'Database connection failed: ' . $e->getMessage());
            }
        } elseif ($step == 4) {
            // Create Admin
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            SystemUser::updateOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'password' => Hash::make($request->password),
                    'role' => 'super_admin'
                ]
            );
        } elseif ($step == 5) {
            // Setup Branding & Finish
            Artisan::call('migrate --force');
            Artisan::call('db:seed --force');
            file_put_contents(storage_path('installed'), 'installed');
            return redirect('/login')->with('success', 'Installation complete!');
        }

        return redirect()->route('install.index', ['step' => $step + 1]);
    }
}