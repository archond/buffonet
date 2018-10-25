<?php

namespace App\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class SmallCustom implements FilterInterface
{
    public function applyFilter(Image $image)
    {
//        return $image->fit(120, 90);

        $callback = function ($constraint) { $constraint->upsize(); };
        return $image->widen(120, $callback)->heighten(90, $callback);
    }
}



