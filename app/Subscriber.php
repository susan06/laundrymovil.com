<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subscribers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id'
    ];

     /**
     * Field type
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer'
    ];

     /**
     * Relationships
     *
     */
    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
