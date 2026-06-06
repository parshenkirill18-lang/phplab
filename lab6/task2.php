<?php
//Наследование
class Cat
{
    private $name;
    private $color;

    public function __construct(string $name, string $color)
    {
        $this->name = $name;
        $this->color = $color;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function sayHello(): string
    {
        return "Мяу! Меня зовут " . $this->getName() . ". Я " . $this->getColor() . " цвета.";
    }
}

// проверка
$cat1 = new Cat("Мурка", "чёрного");
$cat2 = new Cat("Барсик", "рыжего");

echo $cat1->sayHello() . "<br>";
echo $cat2->sayHello();