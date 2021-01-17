<?php declare(strict_types=1);

namespace Jorpo\Enum;

use BadMethodCallException;
use Ds\Hashable;
use ReflectionClass;
use function array_key_exists;
use function array_keys;
use function array_search;
use function get_called_class;
use function get_class;
use function in_array;
use function serialize;

abstract class Enum implements Hashable
{
    protected static $cache;
    protected $value;

    public static function __callStatic($name, $arguments)
    {
        $array = static::toArray();

        if (isset($array[$name]) || \array_key_exists($name, $array)) {
            return new static($array[$name]);
        }

        throw new BadMethodCallException(sprintf(
            "No static method or enum constant '%s' in class %s",
            $name,
            static::class
        ));
    }

    /**
     * @throws InvalidEnumValue
     */
    final public function __construct($value)
    {
        if (is_a($value, static::class)) {
            $value = $value->value();
        }

        if (!static::isValidValue($value)) {
            throw new InvalidEnumValue(sprintf(
                "Value '%s' is not valid for enum '%s'",
                $value,
                get_called_class()
            ));
        }

        $this->value = $value;
    }

    final public function hash(): string
    {
        return serialize($this);
    }

    final public function equals($object): bool
    {
        return get_called_class() === get_class($object) && $object->hash() === $this->hash();
    }

    final public function __toString(): string
    {
        return (string) $this->value;
    }

    final public static function keys(): array
    {
        return array_keys(static::toArray());
    }

    final public function key(): string
    {
        return static::searchFor($this->value);
    }

    final public static function values(): array
    {
        $values = array();

        foreach (static::toArray() as $key => $value) {
            $values[$key] = new static($value);
        }

        return $values;
    }

    final public function value()
    {
        return $this->value;
    }


    final public static function isValidKey($key): bool
    {
        $array = static::toArray();

        return isset($array[$key]) || array_key_exists($key, $array);
    }

    final public static function isValidValue($value): bool
    {
        return in_array($value, static::toArray(), true);
    }

    public static function searchFor($value)
    {
        return array_search($value, static::toArray(), true);
    }

    private static function toArray(): array
    {
        $class = get_called_class();

        if (!isset(static::$cache[$class])) {
            $reflection = new ReflectionClass($class);
            static::$cache[$class] = $reflection->getConstants();
        }

        return static::$cache[$class];
    }
}
