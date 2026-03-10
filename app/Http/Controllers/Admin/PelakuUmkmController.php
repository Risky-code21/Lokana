<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PelakuUmkm;
use App\Http\Requests\StorePelaku_umkmRequest;
use App\Http\Requests\UpdatePelaku_umkmRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelakuUmkmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page', 10);
        // Card stats
        $stats = [
            'total' => PelakuUmkm::count(),
            'today' => PelakuUmkm::whereDate('created_at', today())->count(),
            'weekly' => PelakuUmkm::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
            'monthly' => PelakuUmkm::whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])->count(),
        ];

        // Get paginated data with search functionality
        $pelakuUmkms = PelakuUmkm::query()
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
            
        return view('pages.admin.pelaku-umkm.index', compact('pelakuUmkms', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.pelaku-umkm.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePelaku_umkmRequest $request)
    {
        try {
            PelakuUmkm::create($request->validated());
            
            return redirect()->route('admin.pelaku-umkm.index')
                ->with('success', 'Pelaku UMKM berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal menambahkan pelaku UMKM: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PelakuUmkm $pelakuUmkm)
    {
        return view('pages.admin.pelaku-umkm.show', compact('pelakuUmkm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PelakuUmkm $pelakuUmkm)
    {
        return view('pages.admin.pelaku-umkm.edit', compact('pelakuUmkm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePelaku_umkmRequest $request, PelakuUmkm $pelakuUmkm)
    {
        try {
            $pelakuUmkm->update($request->validated());
            
            return redirect()->route('admin.pelaku-umkm.index')
                ->with('success', 'Pelaku UMKM berhasil diperbarui.');
                
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal memperbarui pelaku UMKM: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PelakuUmkm $pelakuUmkm)
    {
        try {
            $pelakuUmkm->delete();
            
            return redirect()->route('admin.pelaku-umkm.index')
                ->with('success', 'Pelaku UMKM berhasil dihapus.');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus pelaku UMKM: ' . $e->getMessage());
        }
    }
    
    /**
     * Bulk delete multiple records
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:pelaku_umkms,id'
        ]);
        
        try {
            $count = PelakuUmkm::whereIn('id', $request->ids)->delete();
            
            return response()->json([
                'success' => true,
                'message' => "Berhasil menghapus {$count} data pelaku UMKM.",
                'count' => $count
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}