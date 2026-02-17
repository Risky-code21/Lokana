<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUmkmProfileRequest;
use App\Http\Requests\UpdateUmkmProfileRequest;
use App\Services\UmkmProfileService;
use App\Models\UmkmProfile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UmkmProfileController extends Controller
{
    protected $umkmProfileService;
    
    public function __construct(UmkmProfileService $umkmProfileService)
    {
        $this->umkmProfileService = $umkmProfileService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->get('search', ''),
            'category_id' => $request->get('category_id'),
            'status' => $request->get('status'),
            'pelaku_umkm_id' => $request->get('pelaku_umkm_id'),
            'order_by' => $request->get('order_by', 'created_at'),
            'order_dir' => $request->get('order_dir', 'desc'),
        ];
        
        $perPage = $request->get('per_page', 10);
        
        $umkmProfiles = $this->umkmProfileService->getAll($filters, $perPage);
        $stats = $this->umkmProfileService->getStats();
        $dropdowns = $this->umkmProfileService->getDropdownOptions();
        
        return view('pages.admin.umkm-profiles.index', compact(
            'umkmProfiles', 
            'stats', 
            'dropdowns', 
            'filters'
        ));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dropdowns = $this->umkmProfileService->getDropdownOptions();
        
        return view('pages.admin.umkm-profiles.create', compact('dropdowns'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUmkmProfileRequest $request)
    {
        try {
            $this->umkmProfileService->create($request->validated());
            
            return redirect()->route('admin.umkm-profiles.index')
                ->with('success', 'Profil UMKM berhasil dibuat.');
                
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal membuat profil UMKM: ' . $e->getMessage());
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(UmkmProfile $umkmProfile)
    {
        $umkmProfile->load(['pelakuUmkm', 'category', 'products']);
        
        return view('pages.admin.umkm-profiles.show', compact('umkmProfile'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UmkmProfile $umkmProfile)
    {
        $dropdowns = $this->umkmProfileService->getDropdownOptions();
        $umkmProfile->load(['pelakuUmkm', 'category']);
        
        return view('pages.admin.umkm-profiles.edit', compact('umkmProfile', 'dropdowns'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUmkmProfileRequest $request, UmkmProfile $umkmProfile)
    {
        try {
            $this->umkmProfileService->update($umkmProfile, $request->validated());
            
            return redirect()->route('admin.umkm-profiles.index')
                ->with('success', 'Profil UMKM berhasil diperbarui.');
                
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal memperbarui profil UMKM: ' . $e->getMessage());
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UmkmProfile $umkmProfile)
    {
        try {
            $this->umkmProfileService->delete($umkmProfile);
            
            return redirect()->route('admin.umkm-profiles.index')
                ->with('success', 'Profil UMKM berhasil dihapus.');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus profil UMKM: ' . $e->getMessage());
        }
    }
    
    /**
     * Bulk delete profiles
     */
    public function bulkDestroy(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:umkm_profiles,id'
        ]);
        
        try {
            $count = UmkmProfile::whereIn('id', $request->ids)->delete();
            
            return response()->json([
                'success' => true,
                'message' => "Berhasil menghapus {$count} profil UMKM.",
                'count' => $count
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus profil: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get profiles for dropdown (AJAX)
     */
    public function getProfiles(Request $request): JsonResponse
    {
        $search = $request->get('search', '');
        
        $profiles = UmkmProfile::query()
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('name')
            ->limit(20)
            ->get(['id', 'name as text']);
            
        return response()->json([
            'results' => $profiles
        ]);
    }
}