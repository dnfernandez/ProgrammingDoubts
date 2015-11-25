<?php
// file: index.php


define("DEFAULT_CONTROLLER", "pregunta");
define("DEFAULT_ACTION", "index");

function run() {
    // invoke action!
    try {
        if (!isset($_GET["controller"])) {
            $_GET["controller"] = DEFAULT_CONTROLLER;
        }

        if (!isset($_GET["action"])) {
            $_GET["action"] = DEFAULT_ACTION;
        }

        // Here is where the "magic" occurs.
        // URLs like: index.php?controller=posts&action=add
        // will provoke a call to: new PostsController()->add()

        // Instantiate the corresponding controller
        $controller = loadController($_GET["controller"]);
       // $controller = loadController("pregunta");

        // Call the corresponding action
        $actionName = $_GET["action"];
        $controller->$actionName();
    } catch(Exception $ex) {
        //uniform treatment of exceptions
        die("An exception occured!!!!!".$ex->getMessage());
    }
}

/**
 * Load the required controller file and create the controller instance
 *
 * @param string $controllerName The controller name found in the URL
 * @return Object A Controller instance
 */
function loadController($controllerName) {
    $controllerClassName = getControllerClassName($controllerName);

    require_once(__DIR__."/controller/".$controllerClassName.".php");
    return new $controllerClassName();
}

/**
 * Obtain the class name for a controller name in the URL
 *
 * For example $controllerName = "users" will return "UsersController"
 *
 * @param $controllerName The name of the controller found in the URL
 * @return string The controller class name
 */
function getControllerClassName($controllerName) {
    return strToUpper(substr($controllerName, 0, 1)).substr($controllerName, 1)."Controller";
}

//run!
run();

?>