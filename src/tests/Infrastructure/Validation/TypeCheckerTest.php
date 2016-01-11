<?php

namespace Demo\tests\Infrastructure\Validation;

use Demo\Infrastructure\Validation\TypeChecker;
use stdClass;

/**
 * Test for TypeChecker.
 *
 * @package Demo
 *
 * @license Proprietary
 */
class TypeCheckerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider validStringProvider
     *
     * @param string $validString
     */
    public function testAssertStringReturnsTrue($validString)
    {
        $this->assertTrue(TypeChecker::assertString($validString, '$validString'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAssertStringThrowExceptionOnInvalidVariableName()
    {
        $this->assertTrue(TypeChecker::assertString('valid string', 123));
    }

    /**
     * @dataProvider invalidStringProvider
     *
     * @expectedException \InvalidArgumentException
     *
     * @param mixed $invalidValue
     */
    public function testAssertStringThrowExceptionIfAssertInvalid($invalidValue)
    {
        TypeChecker::assertString($invalidValue, '$invalidValue');
    }

    public function testAssertIntReturnsTrue()
    {
        $this->assertTrue(TypeChecker::assertInt(123, '$intVar'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAssertIntThrowExceptionOnInvalidVariableName()
    {
        TypeChecker::assertInt(123, 123);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAssertIntThrowExceptionOnNonIntegerValue()
    {
        TypeChecker::assertInt('this is not an integer', '$varName');
    }

    /**
     * @return array
     */
    public function validStringProvider()
    {
        return [
            ['valid string'],
            ['123'],
            ['!@#$'],
        ];
    }

    /**
     * @return array
     */
    public function invalidStringProvider()
    {
        return [
            [123],
            [new stdClass()],
        ];
    }
}
