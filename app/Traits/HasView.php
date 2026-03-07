<?php

namespace App\Traits;

use App\Models\View;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

trait HasView
{
    /**
     *  Function yang digunakan untuk relasi bertipe polymorphic, jadi setiap model bisa memiliki   relasi dengan model ini dengan bantuan viewable column yang akan otomatis mengenerate column unik
     *
     *  @return MorphMany
     */
    public function views(): MorphMany
    {
        // Parameter kedua 'viewable' otomatis mengacu pada kolom viewable_id & viewable_type
        return $this->morphMany(View::class, 'viewable');
    }

    /**
     *  Function yang digunakan untuk tracking view dari setiap model yang memilii
     *
     *  @return void
     */
    public function recordView()
    {
        $cookieName = 'viewed_' . str_replace('\\', '_', $this->getMorphClass()) . '_' . $this->getKey();

        // 1. Cek Cookie dulu (Benteng pertama)
        if (Cookie::get($cookieName)) {
            return;
        }

        // 2. Tentukan identitas pengunjung
        $visitorId = Auth::id();

        // Jika tidak login, kita bisa pakai IP atau UUID yang disimpan di cookie
        // Tapi untuk database, paling aman gunakan Auth::id() saja jika tersedia
        if ($visitorId) {
            $this->views()->firstOrCreate(
                [
                    'visitor_id'    => $visitorId,
                    'viewable_id'   => $this->getKey(),
                    'viewable_type' => $this->getMorphClass(),
                ],
                [
                    'ip_address' => Request::ip(),
                    'user_agent' => Request::userAgent(),
                ]
            );
        } else {
            // Logika untuk Guest (Opsional: simpan berdasarkan IP saja)
            $this->views()->firstOrCreate(
                [
                    'ip_address'    => Request::ip(),
                    'visitor_id'    => null, // Biarkan null untuk guest
                    'viewable_id'   => $this->getKey(),
                    'viewable_type' => $this->getMorphClass(),
                ],
                [
                    'user_agent' => Request::userAgent(),
                ]
            );
        }

        // 3. Set Cookie (Agar 60 menit ke depan tidak hit database lagi)
        Cookie::queue($cookieName, true, 60);
    }
}
