<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestLagu extends Model
{
    protected $table = 'requests';

    protected $fillable = [
        'judul_lagu',
        'nama_pengirim',
        'ip_address',
        'album_art',
        'bagian_lirik',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
