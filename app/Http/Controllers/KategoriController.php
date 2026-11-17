<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    protected function currentCompanyId(): int
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (! $user) {
            abort(403);
        }

        return (int) $user->company_id;
    }

    public function index()
    {
        $kategoris = Kategori::where(
            'company_id',
            $this->currentCompanyId()
        )->latest()->get();

        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|max:255',
            'deskripsi' => 'nullable'
        ]);

        Kategori::create([
            ...$validated,
            'company_id' => $this->currentCompanyId(),
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Kategori $kategori)
    {
        $kategori = Kategori::where(
            'company_id',
            $this->currentCompanyId()
        )->findOrFail($kategori->getKey());

        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $kategori = Kategori::where(
            'company_id',
            $this->currentCompanyId()
        )->findOrFail($kategori->getKey());

        $validated = $request->validate([
            'nama_kategori' => 'required|max:255',
            'deskripsi' => 'nullable'
        ]);

        $kategori->update($validated);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori = Kategori::where(
            'company_id',
            $this->currentCompanyId()
        )->findOrFail($kategori->getKey());

        $kategori->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
