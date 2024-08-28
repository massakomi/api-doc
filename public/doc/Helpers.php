<?php

namespace SimpleScribe;


use ReflectionException;

class Helpers
{

    /**
     * Получить массив файлов папки
     * @param $dir
     * @return array
     */
    public static function getFiles($dir)
    {
        $a = scandir($dir);
        $files = [];
        foreach ($a as $filename) {
            if ($filename == '.' || $filename == '..') {
                continue;
            }
            $path = $dir . '/' . $filename;
            if (is_dir($path)) {
                $files = array_merge($files, self::getFiles($path));
            } else {
                if (!str_ends_with($filename, '.php')) {
                    continue;
                }
                $files [] = $path;
            }
        }
        return $files;
    }

    /**
     * Получить полное имя класса с namespace при инклюде из файла
     * @param $filepath
     * @return array
     */
    public static function getClassDataByFilepath($filepath)
    {
        $className = basename($filepath, '.php');
        $namespaces = get_declared_classes();
        require_once $filepath;
        $newNamespaces = get_declared_classes();
        $namespacesDiff = array_values(array_diff($newNamespaces, $namespaces));
        $classFullName = false;
        foreach ($namespacesDiff as $class) {
            if (str_ends_with($class, '\\' . $className)) {
                $classFullName = $class;
            }
        }
        return [$className, $classFullName];
    }

    /**
     * Собственные методы класса, заканчивающиеся на Action
     * @param $classFullName
     * @return array
     * @throws ReflectionException
     */
    public static function getClassActionMethods($classFullName)
    {
        $class = new \ReflectionClass($classFullName);
        $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
        $ownMethods = [];
        foreach ($methods as $method) {
            if ($method->class == $classFullName && str_ends_with($method->name, 'Action')) {
                $ownMethods [] = $method->name;
            }
        }
        return $ownMethods;
    }

}