<?php

namespace App\Models;

use App\Models\Room\Room;
use App\Models\Platform\Location;
use App\Models\Platform\Platform;
use Illuminate\Database\Eloquent\Model;
use Nuwave\Lighthouse\Support\Traits\IsRelayConnection;

class User extends \App\Auth\User
{

    use IsRelayConnection;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'client_id'
    ];

    protected $casts = [
        'admin' => 'boolean',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'deleted_at', 'remember_token'
    ];

    /**
     * Get the client that owns the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(\App\Auth\Client::class);
    }

    /**
     * Automatically hash password
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = app('hash')->make($value);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
    public function rooms()
    {
        return $this->hasManyThrough(
            Room::class,
            ClientLocation::class,
            'location_id', // Foreign key on client_location table...
            'client_id', // Foreign key on posts table...
            'client_id', // Local key on users table...
            'location_id' // Local key on client_location table...
        );
    }
     */

}
