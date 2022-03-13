<?php
include('../Utils/AutoLoader.php');

class ErrorController {
    /**
     * @throws Exception
     */
    public function error404(string $path) : void{
        ViewHelper::display(
            $this,
            '404',
            array(
                'path' => $path
            )
        );
    }

    public function error500(string $path) : void{
        ViewHelper::display(
            $this,
            '500',
            array(
                'path' => $path
            )
        );
    }
}