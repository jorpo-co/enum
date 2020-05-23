<?php declare(strict_types=1);

namespace Jorpo\Enum;

class EnumTest extends \PHPUnit\Framework\TestCase
{
    public function testThatEnumCanTestForEquality()
    {
        $subjectOne = new EnumFixture(EnumFixture::FOO);
        $subjectTwo = new EnumFixture(EnumFixture::FOO);
        $subjectThree = new EnumFixture(EnumFixture::NUMBER);

        $this->assertTrue($subjectOne->equals($subjectOne));
        $this->assertTrue($subjectOne->equals($subjectTwo));
        $this->assertFalse($subjectOne->equals($subjectThree));
    }
}
