<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::where(
            'company_id',
            Auth::user()->company_id
        )->latest()->get();

        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_supplier' => 'required|max:255',
            'telepon' => 'nullable|max:30',
            'alamat' => 'nullable'
        ]);

        $supplier = new Supplier($data);
        $supplier->company_id = Auth::user()->company_id;
        $supplier->save();

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan!');
    }

    public function edit(Supplier $supplier)
    {
        $supplier = Supplier::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail($supplier->id);

        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $supplier = Supplier::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail($supplier->id);

        $data = $request->validate([
            'nama_supplier' => 'required|max:255',
            'telepon' => 'nullable|max:30',
            'alamat' => 'nullable'
        ]);

        $supplier->update($data);

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil diperbarui!');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier = Supplier::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail($supplier->id);

        $supplier->delete();

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil dihapus!');
    }
}
