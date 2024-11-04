<?php

function errorHandler($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        return;
    }

    http_response_code(500);
    header('Content-Type: text/html');

    $message = sprintf(
        "<strong>Грешка [%d]:</strong> %s <br> <em>в %s на ред %d</em>",
        $errno,
        $errstr,
        $errfile,
        $errline
    );

    echo "<html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; background-color: #f8d7da; color: #721c24; padding: 20px; }
                    .error { border: 1px solid #f5c6cb; background-color: #f8d7da; padding: 15px; border-radius: 5px; }
                    h1 { color: #721c24; }
                </style>
            </head>
            <body>
                <h1>Грешка!</h1>
                <div class='error'>$message</div>
            </body>
          </html>";
    exit;
}

function exceptionHandler($exception) {
    http_response_code(500);
    header('Content-Type: text/html');

    $message = sprintf(
        "<strong>Неочаквано изключение:</strong> %s <br> <em>в %s на ред %d</em>",
        $exception->getMessage(),
        $exception->getFile(),
        $exception->getLine()
    );

    echo "<html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; background-color: #f8d7da; color: #721c24; padding: 20px; }
                    .error { border: 1px solid #f5c6cb; background-color: #f8d7da; padding: 15px; border-radius: 5px; }
                    h1 { color: #721c24; }
                </style>
            </head>
            <body>
                <h1>Неочаквана грешка!</h1>
                <div class='error'>$message</div>
            </body>
          </html>";
    exit;
}

set_error_handler("errorHandler");
set_exception_handler("exceptionHandler");