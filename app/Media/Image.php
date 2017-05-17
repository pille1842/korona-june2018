<?php

namespace Korona\Media;

use Illuminate\Database\Eloquent\Model;
use Uuid;

class Image extends Model
{
    public function getRouteKeyName()
    {
        return 'path';
    }

    public function imageable()
    {
        return $this->morphTo();
    }

    public function saveFile(\Intervention\Image\Image $image)
    {
        return $image->save(storage_path($this->getStoragePath().$this->getFileName()));
    }

    public function generatePath()
    {
        $this->path = Uuid::generate(4);
    }

    public function getStoragePath()
    {
        return 'app/local/images/';
    }

    public function getFileName()
    {
        return $this->path . '.' . $this->type;
    }
}
