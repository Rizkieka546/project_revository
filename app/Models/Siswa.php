<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'siswa_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'siswa_id',
        'nisn',
        'nama_siswa',
        'jurusan_id',
        'kelas_id',
        'no_siswa',
    ];

    // Relasi ke tabel jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }

    // Relasi ke tabel kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    // Relasi ke tabel peminjaman (seorang siswa bisa memiliki banyak peminjaman)
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'siswa_id', 'siswa_id');
    }
}