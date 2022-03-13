<?php
spl_autoload_register(static function ($name) {
    $projectDir = substr(__DIR__, 0, -6);

    foreach (glob("../Utils/*.php") as $fileName) {
            include_once $fileName;
    }

    $fileName = "";

    if (str_contains($name, "Controller")) {
        $fileName = $projectDir . '/Controllers/'. $name;
    }
    else if (str_contains($name, "Model")) {
        $fileName = $projectDir . '/Models/'. $name;
    }
    else if (str_contains($name, "View")) {
        $fileName = $projectDir . '/Views/'. $name;
    } else {
        $fileName = $projectDir . '/Utils/' . $name;
    }

    $fileName .= '.php';

    if (file_exists($fileName)) {
        include_once $fileName;
    } else {
        throw new Exception("$fileName not found", -1);
    }
});
