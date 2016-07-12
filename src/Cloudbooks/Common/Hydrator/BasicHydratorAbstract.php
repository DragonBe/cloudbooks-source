<?php

namespace Cloudbooks\Common\Hydrator;

use Cloudbooks\Common\Interfaces\HydratorInterface;

abstract class BasicHydratorAbstract implements HydratorInterface
{
    /**
     * @inheritdoc
     */
    public function extract($object): array
    {
        $classMethods = get_class_methods($object);
        $array = [];
        foreach ($classMethods as $classMethod) {
            if (substr($classMethod, 0, 3) !== 'get') continue;
            $key = $this->camelToSnake(substr($classMethod, 3));
            $value = $object->$classMethod();
            $array[$key] = $value;
        }
        return $array;
    }

    /**
     * @inheritdoc
     */
    public function hydrate(array $data, $object)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . $this->snakeToCamel($key);
            if (method_exists($object, $method)) {
                $object->$method($value);
            }
        }
    }

    /**
     * Simple helper functionality to convert a camelCased string
     * into a snake_cased string
     *
     * @param string $string
     * @return string
     */
    protected function camelToSnake(string $string): string
    {
        return ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $string)), '_');
    }

    /**
     * Simple helper functionality to convert a snake_cased string
     * into a camelCased string
     * 
     * @param string $string
     * @return string
     */
    protected function snakeToCamel(string $string): string
    {
        $elements = explode('_', $string);
        $elementCount = count($elements);
        $camelString = $elements[0];
        for ($i = 1; $i < $elementCount; $i++) {
            $camelString .= ucfirst($elements[$i]);
        }
        return $camelString;
    }
}