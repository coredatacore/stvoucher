<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nas;

class NasController extends Controller
{
    public function index()
    {
        $nas = Nas::paginate(20);
        return view('admin.nas.index', compact('nas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nasname' => 'required|string|max:128',
            'shortname' => 'required|string|max:32',
            'type' => 'required|string|max:30',
            'ports' => 'nullable|integer',
            'secret' => 'required|string|max:60',
            'server' => 'nullable|string|max:64',
            'community' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:200',
        ]);

        Nas::create($data);

        return redirect()->route('admin.nas.index')->with('success', 'NAS Client created successfully.');
    }

    public function update(Request $request, string $id)
    {
        $nas = Nas::findOrFail($id);
        
        $data = $request->validate([
            'nasname' => 'required|string|max:128',
            'shortname' => 'required|string|max:32',
            'type' => 'required|string|max:30',
            'ports' => 'nullable|integer',
            'secret' => 'required|string|max:60',
            'server' => 'nullable|string|max:64',
            'community' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:200',
        ]);

        $nas->update($data);

        return redirect()->route('admin.nas.index')->with('success', 'NAS Client updated successfully.');
    }

    public function destroy(string $id)
    {
        $nas = Nas::findOrFail($id);
        $nas->delete();

        return redirect()->route('admin.nas.index')->with('success', 'NAS Client deleted successfully.');
    }
}