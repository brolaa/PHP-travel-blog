<?php

    spl_autoload_register(function ($klasa) {
        $file = 'Model/'.$klasa.'.php';
        if(file_exists($file)){
            require_once $file;
        } else {
            $file = 'View/'.$klasa.'.php';
            if(file_exists($file)) {
                require_once $file;
            } else {
                $file = 'Controller/'.$klasa.'.php';
                require_once $file;
            }
        }
    });

