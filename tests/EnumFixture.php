<?php declare(strict_types=1);

namespace Jorpo\Enum;

class EnumFixture extends Enum
{
    const FOO = "foo";
    const BAR = "bar";
    const NUMBER = 42;

    /**
     * Values that are known to cause problems when used with soft typing
     */
    const PROBLEMATIC_NUMBER = 0;
    const PROBLEMATIC_NULL = null;
    const PROBLEMATIC_EMPTY_STRING = '';
    const PROBLEMATIC_BOOLEAN_FALSE = false;
}
