<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $table = 'views';

    protected $fillable = [
        'viewable_id',
        'viewable_type',
        'user_agent',
        'visitor_id',
        'ip_address'
    ];

    public function viewable()
    {
        return $this->morphTo();
    }

    // cek relasi apakah perlu fillable ?
}
