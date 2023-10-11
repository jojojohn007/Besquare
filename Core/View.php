<?php

namespace Core;

class View
{
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);
        $file = ROOT . '/App/Views/' . $view;
        if (is_readable($file)) {
            require $file;
        } else {
            // echo $file.' not found';
            throw new \Exception($file . ' not found');
        }
    }

    public static  function renderTemplate($template, $arg = [])
    {
        static $twig = null;

    if ($twig === null) { 

            $loader = new \Twig\Loader\FilesystemLoader(
                ROOT . '/App/Views/'
            );
            $twig = new \Twig\Environment($loader,[
                'debug' =>true
            ]);
            $twig->addExtension(new \Twig\Extension\DebugExtension());
            $var = [
                'root' => ASSET_PATH
            ];
            addglobal($twig, $var);
        }


        echo $twig->render($template, $arg);
    }
    public static function redirect(string $url,array|string $incomingData=[], int $http_response_code = 302): void
    {
        // $this->$data
         header("Location: $url", false, $http_response_code);
        exit();
    }
}