<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BiodataController extends Controller
{
    /**
     * Display the biodata cards page.
     */
    public function index(): View
    {
        $biodatas = Biodata::query()->oldest('id')->get();

        return view('welcome', [
            'biodatas' => $biodatas,
        ]);
    }

    /**
     * Store a newly created biodata record.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:2000'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $stored = Storage::disk('public')->putFile('biodata', $request->file('foto'));
            $fotoPath = is_string($stored) ? $stored : null;
        }

        Biodata::create([
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'],
            'foto' => $fotoPath,
        ]);

        return redirect()->route('home')->with('success', 'Biodata berhasil ditambahkan.');
    }

    /**
     * Update the specified biodata record.
     */
    public function update(Request $request, Biodata $biodata): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:2000'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        $fotoPath = $biodata->foto;
        if ($request->hasFile('foto')) {
            $this->deleteStoredFoto($biodata->foto);
            $stored = Storage::disk('public')->putFile('biodata', $request->file('foto'));
            $fotoPath = is_string($stored) ? $stored : $fotoPath;
        }

        $biodata->update([
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'],
            'foto' => $fotoPath,
        ]);

        return redirect()->route('home')->with('success', 'Biodata berhasil diperbarui.');
    }

    /**
     * Remove the specified biodata record.
     */
    public function destroy(Biodata $biodata): RedirectResponse
    {
        $this->deleteStoredFoto($biodata->foto);
        $biodata->delete();

        return redirect()->route('home')->with('success', 'Biodata berhasil dihapus.');
    }

    /**
     * Delete a previously uploaded photo from the public disk.
     */
    private function deleteStoredFoto(?string $foto): void
    {
        if (filled($foto) && ! str_starts_with($foto, 'images/') && ! str_starts_with($foto, 'http')) {
            Storage::disk('public')->delete($foto);
        }
    }
}
