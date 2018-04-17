<?php

/**
 * Room Comment model
 * Holds the comment details of a Room comment, only ment for internal use
 */

namespace App\Models\Room;

use Illuminate\Database\Eloquent\Model;
use Nuwave\Lighthouse\Support\Traits\IsRelayConnection;


class RoomComment extends Model
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
    protected $table = 'api_room_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'uuid', 'reference', 'title', 'content', 'room_id'
    ];

    /**
     * Get the Room that belong to this guest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

}
