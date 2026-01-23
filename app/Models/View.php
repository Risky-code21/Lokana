<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $table = 'views';

    protected $fillable = [
        'user_id',
        'viewable_id',
        'viewable_type',
        'user_agent',
        'ip_address'
    ];

    public function viewable()
    {
        return $this->morphTo();
    }

    // cek relasi apakah perlu fillable ?
}
