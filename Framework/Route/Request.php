<?php

namespace Framework\Route;

class Request {
    public static $Query    = [];
    public static $Body     = [];
    public static $Headers  = [];
    public static $Files    = [];

    public static function get ($key = null) {
        self::getRequest();
        if ($key) {
            if (!in_array($key, self::$Query))  throw new \Exception("Input {$key} not found.");
        }
        return $key ? self::$Query[$key] : self::$Query;
    }

    public static function body ($key = null) {
        self::getRequest();
        if ($key) {
            if (!in_array($key, self::$Body))  throw new \Exception("Input {$key} not found.");
        }
        return $key ? self::$Body[$key] : self::$Body;
    }

    private static function getRequest () {
        // Headers
        self::$Headers = getallheaders();

        // Get
        $g1 = filter_input_array(INPUT_GET);
        self::$Query = $g1;

        // Body
        $b1 = (array) filter_input_array(INPUT_POST);
        $b2 = (array) $_POST;
        $b3 = (array) json_decode(file_get_contents('php://input'), true);
        self::$Body = array_merge($b1, $b2, $b3);
    }
}