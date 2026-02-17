<?php

namespace App\Services;

use App\Models\UmkmProfile;
use App\Models\PelakuUmkm;
use App\Models\CategoryUmkm;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UmkmProfileService
{
    /**
     * Get all UMKM profiles with pagination
     */
    public function getAll(array $filters = [], int $perPage = 10)
    {
        $query = UmkmProfile::with(['pelakuUmkm', 'category']);
        
        // Apply filters
        if (!empty($filters['search'])) {
            $query->where(function($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('short_description', 'like', '%' . $filters['search'] . '%')
                  ->orWhereHas('pelakuUmkm', function($q) use ($filters) {
                      $q->where('name', 'like', '%' . $filters['search'] . '%');
                  });
            });
        }
        
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }
        
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (!empty($filters['pelaku_umkm_id'])) {
            $query->where('pelaku_umkm_id', $filters['pelaku_umkm_id']);
        }
        
        // Ordering
        $orderBy = $filters['order_by'] ?? 'created_at';
        $orderDir = $filters['order_dir'] ?? 'desc';
        $query->orderBy($orderBy, $orderDir);
        
        return $query->paginate($perPage);
    }
    
    /**
     * Create new UMKM profile
     */
    public function create(array $data)
    {
        // Handle thumbnail upload
        if (isset($data['thumbnail']) && $data['thumbnail']->isValid()) {
            $path = $data['thumbnail']->store('umkm/thumbnails', 'public');
            $data['thumbnail'] = $path;
        }
        
        // Ensure slug is unique
        if (isset($data['slug'])) {
            $slug = Str::slug($data['slug']);
            $count = 1;
            while (UmkmProfile::where('slug', $slug)->exists()) {
                $slug = Str::slug($data['slug']) . '-' . $count++;
            }
            $data['slug'] = $slug;
        }
        
        return UmkmProfile::create($data);
    }
    
    /**
     * Update UMKM profile
     */
    public function update(UmkmProfile $umkmProfile, array $data)
    {
        // Handle thumbnail upload
        if (isset($data['thumbnail']) && $data['thumbnail']->isValid()) {
            // Delete old thumbnail if exists
            if ($umkmProfile->thumbnail) {
                Storage::disk('public')->delete($umkmProfile->thumbnail);
            }
            
            $path = $data['thumbnail']->store('umkm/thumbnails', 'public');
            $data['thumbnail'] = $path;
        }
        
        // Handle slug uniqueness (except for current record)
        if (isset($data['slug']) && $data['slug'] !== $umkmProfile->slug) {
            $slug = Str::slug($data['slug']);
            $count = 1;
            while (UmkmProfile::where('slug', $slug)->where('id', '!=', $umkmProfile->id)->exists()) {
                $slug = Str::slug($data['slug']) . '-' . $count++;
            }
            $data['slug'] = $slug;
        }
        
        $umkmProfile->update($data);
        return $umkmProfile->fresh();
    }
    
    /**
     * Delete UMKM profile
     */
    public function delete(UmkmProfile $umkmProfile): bool
    {
        // Delete thumbnail if exists
        if ($umkmProfile->thumbnail) {
            Storage::disk('public')->delete($umkmProfile->thumbnail);
        }
        
        return $umkmProfile->delete();
    }
    
    /**
     * Get stats for dashboard
     */
    public function getStats(): array
    {
        return [
            'total' => UmkmProfile::count(),
            'published' => UmkmProfile::where('status', 'published')->count(),
            'draft' => UmkmProfile::where('status', 'draft')->count(),
            'archived' => UmkmProfile::where('status', 'archived')->count(),
            'by_category' => CategoryUmkm::withCount('umkmProfiles')->get(),
            'recent' => UmkmProfile::with('pelakuUmkm')->latest()->limit(5)->get()
        ];
    }
    
    /**
     * Get options for dropdowns
     */
    public function getDropdownOptions(): array
    {
        return [
            'pelaku_umkms' => PelakuUmkm::orderBy('name')->get(['id', 'name as text']),
            'categories' => CategoryUmkm::orderBy('name')->get(['id', 'name as text']),
            'status_options' => [
                ['id' => 'draft', 'text' => 'Draft'],
                ['id' => 'published', 'text' => 'Published'],
                ['id' => 'archived', 'text' => 'Archived']
            ],
            'years' => $this->getYearOptions()
        ];
    }
    
    /**
     * Get year options for established year
     */
    private function getYearOptions(): array
    {
        $currentYear = now()->year;
        $years = [];
        
        for ($year = $currentYear; $year >= 1900; $year--) {
            $years[] = ['id' => $year, 'text' => $year];
        }
        
        return $years;
    }
}