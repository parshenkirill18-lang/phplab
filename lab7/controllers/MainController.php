<?php

class MainController
{
    public function sayBye(string $name)
    {
        echo "Пока, $name";
    }

    public function sayHello(string $name)
    {
        echo "Привет, $name";
    }
}