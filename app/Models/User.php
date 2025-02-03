<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'tm_user';
    protected $primaryKey = 'user_id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'user_nama',
        'user_pass',
        'user_hak',
        'user_sts'
    ];

    public $timestamps = false;

    public function getAuthPassword()
    {
        return $this->user_pass;
    }

    public function barangInventaris()
    {
        return $this->hasMany(BarangInventaris::class, 'user_id', 'user_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'user_id', 'user_id');
    }

    public function pengembalian()
    {
        return $this->hasMany(Pengembalian::class, 'user_id', 'user_id');
    }
}
