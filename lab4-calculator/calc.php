<?php

if (!isset($_POST['expression'])) {
    exit("Нет выражения");
}

$expr = $_POST['expression'];

$expr = str_replace(' ', '', $expr);

// проверка
if (!preg_match('/^[0-9+\-*\/().]+$/', $expr)) {
    exit("Ошибка ввода");
}


function calc($expr) {

    // убираем внешние скобки
    if ($expr[0] === '(' && $expr[strlen($expr)-1] === ')') {
        $expr = substr($expr, 1, -1);
    }

    // + и - (самый низкий приоритет)
    $depth = 0;
    for ($i = strlen($expr)-1; $i >= 0; $i--) {
        if ($expr[$i] === ')') $depth++;
        if ($expr[$i] === '(') $depth--;

        if ($depth === 0) {
            if ($expr[$i] === '+') {
                return calc(substr($expr, 0, $i)) + calc(substr($expr, $i+1));
            }
            if ($expr[$i] === '-') {
                return calc(substr($expr, 0, $i)) - calc(substr($expr, $i+1));
            }
        }
    }

  
    $depth = 0;
    for ($i = strlen($expr)-1; $i >= 0; $i--) {
        if ($expr[$i] === ')') $depth++;
        if ($expr[$i] === '(') $depth--;

        if ($depth === 0) {
            if ($expr[$i] === '*') {
                return calc(substr($expr, 0, $i)) * calc(substr($expr, $i+1));
            }
            if ($expr[$i] === '/') {
                return calc(substr($expr, 0, $i)) / calc(substr($expr, $i+1));
            }
        }
    }

    
    return (float)$expr;
}

echo calc($expr);