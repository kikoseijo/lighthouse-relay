<?php

namespace App\Models\Platform;

use App\Auth\Client;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_locations';

    /**
     * Disables automatic timestamp columns
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Casted variables using mutators
     */
    protected $casts = [
        'config' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'description', 'started_at', 'server', 'config'];

    /**
     * Locations relation
     */
    public function clients() {
        $this->belongsToMany(Client::class, 'api_client_locations', 'location_id', 'client_id');
    }


}
