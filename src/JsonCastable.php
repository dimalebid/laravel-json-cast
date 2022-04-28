<?php
namespace DimaLebid\LaravelJsonCast;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use DimaLebid\LaravelJsonCast\Fillable\Fillable;
use DimaLebid\LaravelJsonCast\Fillable\HasFillable;

abstract class JsonCastable implements Fillable, Arrayable
{
    use HasFillable;

    public function __construct(array $options = [])
    {
        $this->fill($options, true);
    }

    public function toArray(): array
    {
        return $this->toCollection()->toArray();
    }

    public function toCollection(): Collection
    {
        return collect(get_object_vars($this))->map(function ($value, $key) {
            if ($this->isFillableProperty($key)) {
                return $value->toArray();
            } else {
                return $value;
            }
        });
    }
}
