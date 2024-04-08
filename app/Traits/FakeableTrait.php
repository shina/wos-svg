<?php

namespace App\Traits;

use Mockery\MockInterface;

trait FakeableTrait
{
    public static function initFake()
    {
    }

    /**
     * Examples:
     *
     * 1. Simple mocking - If you want to mock a method named getUserName to return "John Doe":
     * ```
     * ClassName::fake(['getUserName' => 'John Doe']);
     * // or
     * ClassName::fake(['getUserName' => fn() => 'John Doe']);
     * ```
     *
     * 2. Mocking with arguments - If you want to mock a method named getUserById to return "John Doe" only when it's
     * called with the argument 1
     * ```
     * ClassName::fake([
     *     'getUserById' => [
     *         'args' => [1],
     *         'value' => 'John Doe'
     *     ]
     * ]);
     * // or
     * ClassName::fake([
     *     'getUserById' => [
     *         'args' => [1],
     *         'value' => fn() => 'John Doe'
     *     ]
     * ]);
     * ```
     *
     * 3. Mocking to Throw Exceptions - If you want to mock a method named deleteUser to throw an exception when called
     * ```
     * ClassName::fake([
     *     'deleteUser' => [
     *        'throw' => new Exception("Cannot delete user.")
     *     ]
     * ]);
     * ```
     *
     * 4. Complex mocking - If you want to mock multiple methods with different behaviors
     * ```
     * ClassName::fake([
     *     'getUserName' => 'John Doe',
     *     'getUserAge' => fn() => 25,
     *     'deleteUser' => [
     *         'args' => [1],
     *         'throw' => new Exception("Cannot delete user with ID 1.")
     *     ]
     * ]);
     * ```
     *
     * 5. Any other Mockery API usage with the benefit of auto-binding and initFake
     * ```
     * $class = ClassName::fake();
     * $class->shouldReceive('foo')
     *   ->once();
     * ```
     *
     * @return self|MockInterface
     */
    public static function fake(array $return = []): self
    {
        self::initFake();

        app()->bind(self::class, function () use ($return) {
            return \Mockery::mock(self::class, function (MockInterface $mock) use ($return) {
                collect($return)->each(
                    function ($value, string $funcName) use ($mock) {
                        $mockMethod = $mock->shouldReceive($funcName);

                        if (is_array($value) && isset($value['args'])) {
                            $mockMethod = $mockMethod->withArgs($value['args']);
                            $value = $value['value'];
                        }

                        if (is_array($value) && isset($value['throw'])) {
                            return $mockMethod->andThrow($value['throw']);
                        }

                        return $mockMethod->andReturn(is_callable($value) ? $value() : $value);
                    }
                );
            });
        });

        return resolve(self::class);
    }
}
