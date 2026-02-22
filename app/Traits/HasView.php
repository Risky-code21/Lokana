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
        // Generate Key Cookie Unik
        $cookieName = 'viewed_' . str_replace('\\', '_', $this->getMorphClass()) . '_' . $this->getKey();

        // Cek Cookie (Cegah Spam)
        if (Cookie::get($cookieName)) {
            return;
        }

        // Simpan data view ke Database
        $this->views()->firstOrCreate([
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'visitor_id'    => Auth::id() ?? Str::uuid(), // Nullable
        ]);

        // 4. Set Cookie 60 menit
        Cookie::queue($cookieName, true, 60);
    }
}
