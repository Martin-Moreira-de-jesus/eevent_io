<?php

class AbstractController {
    public function dataPost($name) {
        return $_POST[$name] ?? null;
    }

    public function dataGet($name) {
        return $_GET[$name] ?? null;
    }

    public function mapDataPostToClass($classname) {
        if (class_exists($classname)) {
            $obj = new $classname();
            foreach ($_POST as $dataKey => $dataValue) {
                $setter = "set$dataKey";
                if (method_exists($obj, $setter)) {
                    $obj->$setter($dataValue);
                }
            }
            return $obj;
        }
        return null;
    }
}