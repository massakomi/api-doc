<?php

namespace SimpleScribe;

use ReflectionException;

/**
 * Упрощенная версия на основе синтаксиса .scribe, предназначенная для генерации документации для bitrix-api
 * приложения, где есть разделение на контроллеры и роуты. Альтернатива swagger
 */
class Doc
{
    private string $dirControllers;
    private string $dirRoutes;
    private $baseApiUrl;

    public function __construct()
    {
        $envFile = '.env';
        if (!file_exists($envFile)) {
            throw new \Exception('Not found .env file');
        }
        $env = parse_ini_file($envFile);
        $this->dirControllers = $env['DIR_CONTROLLERS'];
        $this->dirRoutes = $env['DIR_ROUTES'];
        $this->baseApiUrl = $env['BASE_API_URL'];
    }

    /**
     * Извлекает информацию о методах класса
     * @param $classFullName
     * @return array
     * @throws ReflectionException
     */
    public function scanMethods($classFullName)
    {
        $methods = Helpers::getClassActionMethods($classFullName);
        if (!$methods) {
            return [];
        }
        $dc = new DocComment();
        $methodsData = [];
        foreach ($methods as $key => $methodName) {
            $method = new \ReflectionMethod($classFullName, $methodName);
            $comment = $method->getDocComment();
            $lines = $dc->parse($comment);
            $methodsData [$methodName] = $lines;
        }
        return $methodsData;
    }

    /**
     * Извлекает всю информацию по методам из контроллера
     * @param $byGroup
     * @return array
     * @throws ReflectionException
     */
    public function scanAllComments($byGroup = true)
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . $this->dirControllers;
        if (!file_exists($dir)) {
            throw new \Exception('Controllers folder "'.$dir.'" not found!');
        }
        $files = Helpers::getFiles($dir);
        $data = [];
        foreach ($files as $filepath) {
            [$className, $classFullName] = Helpers::getClassDataByFilepath($filepath);
            $methodsData = $this->scanMethods($classFullName);
            if ($byGroup) {
                foreach ($methodsData as $method => $info) {
                    $group = $info['group'] ?: 'Unknown';
                    $info ['class'] = $classFullName;
                    $data [$group][$method] = $info;
                }
            } else {
                $data [$className] = $methodsData;
            }
        }
        return $data;
    }

    /**
     * Все роуты и привязки методов к паттернам
     * @return array
     * @throws \Exception
     */
    public function scanAllRoutes()
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . $this->dirRoutes;
        if (!file_exists($dir)) {
            return [];
        }
        $routesFiles = Helpers::getFiles($dir);
        $methodsData = [];
        foreach ($routesFiles as $filepath) {
            $routes = require $filepath;
            $filename = str_replace($dir, '', $filepath);
            $apiName = explode('/', substr($filename, 1))[0];
            foreach ($routes as $route) {
                $handle = $route['handle'];
                if (!$handle) {
                    continue;
                }
                [$object, $method] = $handle();
                if (array_key_exists($method, $methodsData)) {
                    throw new \Exception('Найден дубль метода ' . $method); // todo
                }
                $methodsData [$method . 'Action'] = [$route['method'], $route['pattern'], $apiName];
            }
        }
        return $methodsData;
    }

    public function addRoutesInfo(&$data) {
        $routes = $this->scanAllRoutes();
        foreach ($data as &$methods) {
            foreach ($methods as $method => &$info) {
                if (!array_key_exists($method, $routes)) {
                    if (array_key_exists('showNotFoundRoutes', $_GET)) {
                        echo '<div class="block__red">Не найден роут для метода ' . $method . ' класса ' . $info['class'] . '</div>   ';
                    }
                    unset($methods[$method]);
                    continue;
                }
                [$requestMethod, $pattern, $apiName] = $routes[$method];
                $info ['requestMethod'] = $requestMethod;
                $info ['url'] = $this->baseApiUrl . $apiName . $pattern;
            }
        }
        foreach ($data as $groupName => $methodsData) {
            if (!$methodsData) {
                unset($data[$groupName]);
            }
        }
    }

}

/**
 * Комментарий
 *
 * @group Группа
 *
 * @responseField id Описание поля
 *
 * @param int $id Описание параметра
 *
 * @return array|bool
 */