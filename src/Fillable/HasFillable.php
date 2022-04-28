<?php
namespace DimaLebid\LaravelJsonCast\Fillable;

trait HasFillable
{
    public function fill(array $options, bool $ignoreEmpty = false): void
    {
        foreach ($options as $name => $value) {
            if (property_exists($this, $name)) {
                if ($this->isFillableProperty($name)) {
                    $this->{$name}->fill($value, $ignoreEmpty);
                } elseif ($ignoreEmpty === false || ($ignoreEmpty && $value !== null)) {
                    $this->{$name} = $value;
                }
            }
        }
    }

    private function isFillableProperty(string $name): bool
    {
        $value = $this->{$name};

        return is_object($value) && $value instanceof Fillable;
    }
}
