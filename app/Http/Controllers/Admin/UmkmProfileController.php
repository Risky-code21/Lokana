<?php
// app/Http/Controllers/Admin/UmkmProfileController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmProfile;
use App\Models\CategoryUmkm;
use App\Models\PelakuUmkm;
use App\Models\User;
use App\Models\SubscriptionPlan;
use App\Http\Requests\StoreUmkmProfileRequest;
use App\Http\Requests\UpdateUmkmProfileRequest;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UmkmProfileController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index(Request $request)
    {
        $query = UmkmProfile::with(['category', 'owner', 'subscriptionPlan']);

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nama_pemilik', 'like', "%{$search}%")
                  ->orWhere('whatsapp_number', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('profile_status', $request->status);
        }

        // Filter by verification
        if ($request->has('verification') && $request->verification != '') {
            $query->where('verification_status', $request->verification);
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Filter by city
        if ($request->has('city') && $request->city != '') {
            $query->where('city', 'like', "%{$request->city}%");
        }

        // Hitung stats
        $stats = [
            'total' => UmkmProfile::count(),
            'active' => UmkmProfile::where('profile_status', 'published')
                                   ->where('subscription_status', 'active')
                                   ->count(),
            'pending' => UmkmProfile::where('profile_status', 'pending')->count(),
            'verified' => UmkmProfile::where('verification_status', 'verified')->count(),
        ];

        $profiles = $query->latest()->paginate(12)->withQueryString();
        
        $categories = CategoryUmkm::all();

        return view('pages.admin.umkm-profile.index', compact('profiles', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = CategoryUmkm::all();
        
        // UBAH INI: dari User ke PelakuUmkm
        $pelakuUmkm = PelakuUmkm::all();  // Ambil semua data dari tabel pelaku_umkms
        
        $subscriptionPlans = SubscriptionPlan::where('is_active', true)->get();

        // UBAH juga compact variable dari 'users' ke 'pelakuUmkm'
        return view('pages.admin.umkm-profile.create', compact('categories', 'pelakuUmkm', 'subscriptionPlans'));
    }

        public function store(StoreUmkmProfileRequest $request)
        {

                dd([
                    'message' => 'Store method reached',
                    'method' => $request->method(),
                    'url' => $request->fullUrl(),
                    'data' => $request->all(),
                    'ajax' => $request->ajax(),
                    'wants_json' => $request->wantsJson()
                ]);
                
            // LOG SEMUA DATA YANG MASUK
            \Log::info('===== STORE METHOD CALLED =====');
            \Log::info('Request method: ' . $request->method());
            \Log::info('Request URL: ' . $request->fullUrl());
            \Log::info('Request data:', $request->all());
            \Log::info('Validated data:', $request->validated());
            
            DB::beginTransaction();
            
            try {
                $data = $request->except(['logo', 'thumbnail', 'gallery_images', 'payment_proof']);
                \Log::info('Data after except:', $data);
                
                // Generate slug
                $data['slug'] = Str::slug($request->name);
                \Log::info('Slug generated: ' . $data['slug']);
                
                // Cek file uploads
                \Log::info('Has logo: ' . ($request->hasFile('logo') ? 'YES' : 'NO'));
                \Log::info('Has thumbnail: ' . ($request->hasFile('thumbnail') ? 'YES' : 'NO'));
                \Log::info('Has gallery: ' . ($request->hasFile('gallery_images') ? 'YES' : 'NO'));
                \Log::info('Has payment proof: ' . ($request->hasFile('payment_proof') ? 'YES' : 'NO'));
                
                // Upload logo
                if ($request->hasFile('logo')) {
                    $data['logo'] = $this->fileUploadService->uploadFile($request->file('logo'), 'umkm/logo');
                    \Log::info('Logo uploaded: ' . $data['logo']);
                }
                
                // Upload thumbnail
                if ($request->hasFile('thumbnail')) {
                    $data['thumbnail'] = $this->fileUploadService->uploadFile($request->file('thumbnail'), 'umkm/thumbnail');
                    \Log::info('Thumbnail uploaded: ' . $data['thumbnail']);
                }
                
                // Upload gallery images
                if ($request->hasFile('gallery_images')) {
                    $data['gallery_images'] = $this->fileUploadService->uploadMultipleFiles(
                        $request->file('gallery_images'), 
                        'umkm/gallery'
                    );
                    \Log::info('Gallery uploaded: ', $data['gallery_images']);
                }
                
                // Upload payment proof if exists
                if ($request->hasFile('payment_proof')) {
                    $data['payment_proof'] = $this->fileUploadService->uploadFile(
                        $request->file('payment_proof'), 
                        'umkm/payments'
                    );
                    $data['subscription_status'] = 'pending';
                    \Log::info('Payment proof uploaded: ' . $data['payment_proof']);
                }
                
                // Set default status
                $data['profile_status'] = $data['profile_status'] ?? 'draft';
                $data['verification_status'] = 'pending';
                $data['views_count'] = 0;
                
                \Log::info('Final data before create:', $data);
                
                // Create profile
                $profile = UmkmProfile::create($data);
                
                \Log::info('Profile created successfully with ID: ' . $profile->id);
                
                DB::commit();
                
                \Log::info('Transaction committed');
                \Log::info('===== STORE METHOD END (SUCCESS) =====');
                
                return redirect()
                    ->route('admin.umkm-profiles.index')
                    ->with('success', 'UMKM Profile berhasil ditambahkan');
                    
            } catch (\Exception $e) {
                DB::rollBack();
                
                \Log::error('===== STORE METHOD ERROR =====');
                \Log::error('Error message: ' . $e->getMessage());
                \Log::error('Error file: ' . $e->getFile() . ':' . $e->getLine());
                \Log::error('Error trace: ' . $e->getTraceAsString());
                
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

    public function show(UmkmProfile $umkmProfile)
    {
        $umkmProfile->load(['category', 'owner', 'subscriptionPlan', 'verifiedBy']);
        
        return view('pages.admin.umkm-profile.show', compact('umkmProfile'));
    }

    public function edit(UmkmProfile $umkmProfile)
    {
        $categories = CategoryUmkm::all();
        
        // UBAH INI: dari User ke PelakuUmkm
        $pelakuUmkm = PelakuUmkm::all();  // Ambil semua data dari tabel pelaku_umkms
        
        $subscriptionPlans = SubscriptionPlan::where('is_active', true)->get();
        
        // UBAH juga compact variable dari 'users' ke 'pelakuUmkm'
        return view('pages.admin.umkm-profile.edit', compact('umkmProfile', 'categories', 'pelakuUmkm', 'subscriptionPlans'));
    }

    public function update(UpdateUmkmProfileRequest $request, UmkmProfile $umkmProfile)
    {
        DB::beginTransaction();
        
        try {
            $data = $request->except(['logo', 'thumbnail', 'gallery_images', 'payment_proof', '_token', '_method']);
            
            // Update slug if name changed
            if ($request->has('name') && $request->name != $umkmProfile->name) {
                $data['slug'] = Str::slug($request->name);
            }
            
            // Upload logo (replace old)
            if ($request->hasFile('logo')) {
                $data['logo'] = $this->fileUploadService->uploadFile(
                    $request->file('logo'), 
                    'umkm/logo',
                    $umkmProfile->logo
                );
            }
            
            // Upload thumbnail (replace old)
            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = $this->fileUploadService->uploadFile(
                    $request->file('thumbnail'), 
                    'umkm/thumbnail',
                    $umkmProfile->thumbnail
                );
            }
            
            // Handle gallery images
            if ($request->hasFile('gallery_images')) {
                $existingImages = $umkmProfile->gallery_images ?? [];
                $newImages = $this->fileUploadService->uploadMultipleFiles(
                    $request->file('gallery_images'), 
                    'umkm/gallery'
                );
                
                if ($request->has('replace_gallery') && $request->replace_gallery) {
                    $this->fileUploadService->deleteMultipleFiles($existingImages);
                    $data['gallery_images'] = $newImages;
                } else {
                    $data['gallery_images'] = array_merge($existingImages, $newImages);
                }
            }
            
            // Upload payment proof if exists
            if ($request->hasFile('payment_proof')) {
                $data['payment_proof'] = $this->fileUploadService->uploadFile(
                    $request->file('payment_proof'), 
                    'umkm/payments',
                    $umkmProfile->payment_proof
                );
            }
            
            $umkmProfile->update($data);
            
            DB::commit();
            
            return redirect()
                ->route('admin.umkm-profiles.index')
                ->with('success', 'UMKM Profile berhasil diupdate');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(UmkmProfile $umkmProfile)
    {
        try {
            $umkmProfile->delete();
            
            return redirect()
                ->route('admin.umkm-profiles.index')
                ->with('success', 'UMKM Profile berhasil dihapus');
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Additional methods (verify, reject, toggleFeatured, etc)
    public function verify(UmkmProfile $umkmProfile)
    {
        DB::beginTransaction();
        
        try {
            $umkmProfile->update([
                'verification_status' => 'verified',
                'verified_at' => now(),
                'verified_by' => auth()->id(),
                'profile_status' => 'published'
            ]);
            
            DB::commit();
            
            return redirect()
                ->back()
                ->with('success', 'UMKM Profile berhasil diverifikasi');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, UmkmProfile $umkmProfile)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);
        
        DB::beginTransaction();
        
        try {
            $umkmProfile->update([
                'verification_status' => 'rejected',
                'admin_notes' => $request->rejection_reason,
                'profile_status' => 'draft'
            ]);
            
            DB::commit();
            
            return redirect()
                ->back()
                ->with('success', 'UMKM Profile ditolak');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function toggleFeatured(UmkmProfile $umkmProfile)
    {
        $umkmProfile->update([
            'is_featured' => !$umkmProfile->is_featured
        ]);
        
        $status = $umkmProfile->is_featured ? 'ditambahkan ke' : 'dihapus dari';
        
        return redirect()
            ->back()
            ->with('success', "UMKM Profile {$status} featured");
    }
}