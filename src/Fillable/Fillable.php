<?php
namespace DimaLebid\LaravelJsonCast\Fillable;

interface Fillable
{
    public function fill(array $options, bool $ignoreEmpty): void;
}
