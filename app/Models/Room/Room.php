<?php

namespace App\Models\Room;

use Nuwave\Lighthouse\Support\Traits\IsRelayConnection;

class Room extends \Baum\Node
{

    use IsRelayConnection;

    /**
     * The connection name for the model.
     *
     * @var string
     protected $connection = 'api';
     */


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_rooms';

    /**
     * Disables automatic timestamp columns
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'reference', 'name', 'available', 'details', 'sort', 'location', 'parent_id', 'lft', 'rgt', 'level'];

    /**
     * Casted variables using mutators
     */
    protected $casts = [
        'details' => 'array',
    ];

//    protected $guarded = array('id', 'parent_id', 'lft', 'rgt');
    protected $depthColumn = 'level';

    /**
     * Read the status from details json
     *
     */
    public function getStatusAttribute() {

        return $this->details['status'];

    }

    /**
     * Read the guests from details json
     * @TODO refactor this to use the Guest model
     *
     */
    public function getGuestsAttribute() {

        return $this->details->guests;

    }

    /**
     * Get the Comments for this room
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() {
        return $this->hasMany(RoomComment::class);
    }

}
