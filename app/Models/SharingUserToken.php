<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SharingUserToken extends Model
{
    protected $table ='sharing_user_tokens';
    protected $fillable = ['session_id','user_id','token','status','token_used'];
    /**
     * Get the user that owns the SharingUserToken
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
