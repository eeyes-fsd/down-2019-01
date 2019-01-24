<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function win_file()
    {
        return $this->hasOne(File::class);
    }

    public function mac_file()
    {
        return $this->hasOne(File::class);
    }
}
