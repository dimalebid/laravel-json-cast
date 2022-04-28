<?php
namespace Lebid\LaravelJsonCast\Fillable;

interface Fillable
{
    public function fill(array $options, bool $ignoreEmpty): void;
}
