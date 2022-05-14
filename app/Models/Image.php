<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Return the file's absolute path.
     *
     * @return string
     */
    public function getFilePath(): string
    {
        return storage_path(
            'app' . DIRECTORY_SEPARATOR
            . 'images' . DIRECTORY_SEPARATOR
            . $this->id . DIRECTORY_SEPARATOR
            . $this->filename
        );
    }
}
