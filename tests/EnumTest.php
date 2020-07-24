<?php declare(strict_types=1);

namespace Jorpo\Enum;

use BadMethodCallException;

class EnumTest extends \PHPUnit\Framework\TestCase
{
    public function testThatValueCanBeRetrieved()
    {
        $value = new EnumFixture(EnumFixture::FOO);
        $this->assertEquals(EnumFixture::FOO, $value->value());

        $value = new EnumFixture(EnumFixture::BAR);
        $this->assertEquals(EnumFixture::BAR, $value->value());

        $value = new EnumFixture(EnumFixture::NUMBER);
        $this->assertEquals(EnumFixture::NUMBER, $value->value());
    }

    public function testThatAllValuesCanBeRetrieved()
    {
        $value = new EnumFixture(EnumFixture::FOO);
        $this->assertIsArray($value->values());
    }

    public function testThatKeyCanBeRetrieved()
    {
        $value = new EnumFixture(EnumFixture::FOO);
        $this->assertEquals('FOO', $value->key());
    }

    public function testThatAllKeysCanBeRetrieved()
    {
        $value = new EnumFixture(EnumFixture::FOO);
        $this->assertIsArray($value->keys());
        $this->assertContains('FOO', $value->keys());
    }

    public function testCreatingEnumWithInvalidValue()
    {
        $this->expectException(InvalidEnumValue::class);
        new EnumFixture(1234);
    }

    public function testThatEnumConvertsToString()
    {
        $this->assertSame(EnumFixture::FOO, (string) (new EnumFixture(EnumFixture::FOO)));
    }

    public function testThatEnumCanTestForEquality()
    {
        $subjectOne = new EnumFixture(EnumFixture::FOO);
        $subjectTwo = new EnumFixture(EnumFixture::FOO);
        $subjectThree = new EnumFixture(EnumFixture::NUMBER);

        $this->assertTrue($subjectOne->equals($subjectOne));
        $this->assertTrue($subjectOne->equals($subjectTwo));
        $this->assertFalse($subjectOne->equals($subjectThree));
    }

    public function testThatEnumCanBeCreatedStatically()
    {
        $this->assertTrue((new EnumFixture(EnumFixture::FOO))->equals(EnumFixture::FOO()));
    }

    public function testCreatingInvalidEnumStatically()
    {
        $this->expectException(BadMethodCallException::class);
        EnumFixture::BADGERS();
    }

    public function testThatEnumCanBeCreatedFromAnotherEnum()
    {
        $subjectOne = new EnumFixture(EnumFixture::FOO);
        $subjectTwo = new EnumFixture($subjectOne);

        $this->assertTrue($subjectOne->equals($subjectTwo));
    }

    public function testThatKeysCanBeValidated()
    {
        $this->assertTrue(EnumFixture::isValidKey('FOO'));
        $this->assertFalse(EnumFixture::isValidKey('BAZ'));
    }

    public function testThatValuesCanBeValidated()
    {
        $this->assertTrue(EnumFixture::isValidValue('foo'));
        $this->assertFalse(EnumFixture::isValidValue('baz'));
    }

    public function testThatKeyCanBeFoundForValue()
    {
        $this->assertSame('FOO', EnumFixture::searchFor('foo'));
    }
}
