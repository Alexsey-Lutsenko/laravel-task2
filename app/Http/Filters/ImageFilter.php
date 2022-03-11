<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ImageFilter extends AbstractFilter
{
    public const TITLE_ID = 'title_id';

    protected function getCallbacks(): array
    {
        return [
            self::TITLE_ID => [$this, 'title_id'],
        ];
    }

    public function title_id(Builder $builder, $value)
    {
        $builder->where('title_id', '=', $value);
    }
}
