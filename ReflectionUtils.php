<?php
/**
 * Author: JimmDiGriz
 */

namespace jimmdigriz\utils;

use ReflectionClass;
use ReflectionMethod;

class ReflectionUtils
{
    /**
     * Never use to protected.
     *
     * @param string $className
     * @param string $fieldName
     * @param null $classInstance
     *
     * @return mixed|null
     * @throws \ReflectionException
     */
    public static function getPropertyValue(string $className, string $fieldName, $classInstance = null)
    {
        $reflectionClass = new ReflectionClass($className);

        $reflectionProperty = $reflectionClass->getProperty($fieldName);
        $isStatic = $reflectionProperty->isStatic();
        $isPublic = $reflectionProperty->isPublic();


        if (!$isPublic) {
            $reflectionProperty->setAccessible(true);
        }

        if (!$classInstance && !$isStatic) {
            if (!$isStatic) {
                $classInstance = new $className;
            } else {
                $classInstance = null;
            }
        }

        $value = $reflectionProperty->getValue($classInstance);

        if (!$isPublic) {
            $reflectionProperty->setAccessible(false);
        }

        return $value;
    }

    /** @noinspection MoreThanThreeArgumentsInspection */
    /**
     * Never use to protected.
     *
     * @param $className
     * @param $propertyName
     * @param $value
     * @param null $instance
     *
     * @throws \ReflectionException
     */
    public static function setPropertyValue(string $className, string $propertyName, $value, $instance = null): void
    {
        $reflectionClass = new ReflectionClass($className);

        $reflectionProperty = $reflectionClass->getProperty($propertyName);
        $isPublic = $reflectionProperty->isPublic();
        $isStatic = $reflectionProperty->isStatic();

        if ($isStatic) {
            $reflectionProperty->setValue($value);
            return;
        }

        if (!$instance && !$isStatic) {
            if (!$isStatic) {
                $instance = new $className;
            } else {
                $instance = null;
            }
        }

        if (!$isPublic) {
            $reflectionProperty->setAccessible(true);
        }

        $reflectionProperty->setValue($instance, $value);

        if (!$isPublic) {
            $reflectionProperty->setAccessible(false);
        }
    }

    /**
     * Never use to protected.
     *
     * @param array $parameters ['className', 'methodName', 'instance', 'arguments']
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public static function invokeMethod(array $parameters)
    {
        $className = ArrayUtils::getOrDefault($parameters, 'className');
        $methodName = ArrayUtils::getOrDefault($parameters, 'methodName');
        $instance = ArrayUtils::getOrDefault($parameters, 'instance');
        $arguments = ArrayUtils::getOrDefault($parameters, 'arguments', []);

        if (!$className || !$methodName) {
            return null;
        }

        $reflectionMethod = new ReflectionMethod($className, $methodName);

        $isStatic = $reflectionMethod->isStatic();
        $isPublic = $reflectionMethod->isPublic();

        if (!$instance) {
            if (!$isStatic) {
                $instance = new $className;
            } else {
                $instance = null;
            }
        }

        if (!$isPublic) {
            $reflectionMethod->setAccessible(true);
        }

        $returnValue = $reflectionMethod->invokeArgs($instance, $arguments);

        if (!$isPublic) {
            $reflectionMethod->setAccessible(false);
        }

        return $returnValue;
    }

    /**
     * @param string $className
     * @param $searchValue
     * @return string
     * @throws \ReflectionException
     */
    public static function getConstantName(string $className, $searchValue): ?string
    {
        $class = new ReflectionClass($className);
        $constants = $class->getConstants();

        $constName = null;
        foreach ($constants as $name => $value) {
            if ($value === $searchValue) {
                return $name;
            }
        }

        return null;
    }
}