<?php

namespace App\Models;

use Awcodes\Curator\Models\Media as CuratorMedia;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Media extends CuratorMedia
{
    use HasUuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';
}
