<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsersLog extends Model
{
    use HasFactory;


    protected $guarded = ['id'];

    public $timestamps = true;

    protected $fillable = [

        'user_id',
        'ip',
        'action',
        'created_at',
        'updated_at',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
