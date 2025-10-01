<?php<?php



namespace App\Models;namespace App\Models;



use Awcodes\Curator\Models\Media as BaseCuratorMedia;use Awcodes\Curator\Models\Media as CuratorMedia;

use Illuminate\Database\Eloquent\Casts\Attribute;use Illuminate\Database\Eloquent\Concerns\HasUuids;

use Illuminate\Support\Facades\Storage;

class Media extends CuratorMedia

class Media extends BaseCuratorMedia{

{    use HasUuids;

    /**

     * Override the url accessor to bypass temporary URL generation issues    /**

     */     * Indicates if the IDs are auto-incrementing.

    public function url(): Attribute     *

    {     * @var bool

        return Attribute::make(     */

            get: function (): ?string {    public $incrementing = false;

                try {

                    // Always use the direct Storage URL for simplicity    /**

                    return Storage::disk($this->disk)->url($this->path);     * The "type" of the auto-incrementing ID.

                } catch (\Exception $e) {     *

                    // Fallback for public disk     * @var string

                    if ($this->disk === 'public') {     */

                        return asset('storage/' . $this->path);    protected $keyType = 'string';

                    }}

                    return null;
                }
            },
        );
    }
}