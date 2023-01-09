<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Alfa6661\AutoNumber\AutoNumberTrait;


class Barang extends Model
{
    use HasFactory, AutoNumberTrait;
    protected $table = 'barangs';
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    public function getAutoNumberOptions()
    {
        return [
            'kode' => [
                'format' => function () {
                    return 'MKN-?';
                },
                'length' => 5
            ]
        ];
    }
}
