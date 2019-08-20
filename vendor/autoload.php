<?php
define('DS', DIRECTORY_SEPARATOR);
// Simplificar ou Generalizar ...
$getJsonDirs = function($filename) {
    $file_path = dirname(__DIR__, 1) . DS . "{$filename}.json";
    $json = null;
    if (file_exists($file_path)) {
        $json = file_get_contents($file_path);
    }
    return $json ? json_decode( $json , true) : false;
};

spl_autoload_register(function ($class_full_name) use ($getJsonDirs) {
    $autoloadJson = $getJsonDirs("autoload");
    if (!is_array($autoloadJson)) throw new Exception("Missing autoload.json file.");
    $classes = $autoloadJson["class"];
    $classNameAsArray = explode("\\", $class_full_name);
    $main_namespace = $classNameAsArray[0]; // From App\Controller Get -> App

    $class_name = function () use ($classNameAsArray) {
        $class_name_result = "";
        foreach ($classNameAsArray as $index => $classNamePiece) {
            if ($index == 0) continue;
            $class_name_result .= DS . $classNamePiece;
        }
        return $class_name_result;
    };

    $classes_namespaces = array_keys($classes); // Get all namespaces from autoload json
    if (!in_array($main_namespace, $classes_namespaces)) throw new Exception("Class {$main_namespace} not found in autoload.json classes");
    $full_path = trim(dirname(__DIR__, 1) . DS . $classes[$main_namespace] . $class_name(), "/");

    try {
        require str_replace("\\", DS, $full_path) . ".php";
    } catch (\Throwable $th) {
        throw $th;
    }
});
