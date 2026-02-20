<?php

namespace App\Traits;

use App\Models\View;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;

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
        // 1. Generate Key Cookie Unik
        // $this->getMorphClass() = Mengambil nama model (misal: 'article' atau 'App\Models\Article')
        // $this->getKey() = Mengambil ID model (misal: 5)
        $cookieName = 'viewed_' . str_replace('\\', '_', $this->getMorphClass()) . '_' . $this->getKey();

        // 2. Cek Cookie (Cegah Spam)
        if (Cookie::get($cookieName)) {
            return; // Stop jika sudah dilihat
        }

        // 3. Simpan ke Database
        // MAGIC DISINI:
        // Saat kita panggil $this->views()->create(...),
        // Laravel OTOMATIS mengisi 'viewable_id' dengan $this->id
        // dan 'viewable_type' dengan class model ini.
        $this->views()->create([
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'user_id'    => Auth::id(), // Nullable
        ]);

        // 4. Set Cookie 60 menit
        Cookie::queue($cookieName, true, 60);
    }
}
