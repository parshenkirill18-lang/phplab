<?php
//Инкапсуляция
interface CalculateSquare
{
    public function getSquare(): float;
}

class Square implements CalculateSquare
{
    private $side;

    public function __construct(float $side)
    {
        $this->side = $side;
    }

    public function getSquare(): float
    {
        return $this->side * $this->side;
    }
}

class Circle implements CalculateSquare
{
    private $radius;

    public function __construct(float $radius)
    {
        $this->radius = $radius;
    }

    public function getSquare(): float
    {
        return pi() * $this->radius * $this->radius;
    }
}

class Triangle
{
    private $base;
    private $height;

    public function __construct(float $base, float $height)
    {
        $this->base = $base;
        $this->height = $height;
    }
}

function printSquareInfo($object)
{
    if ($object instanceof CalculateSquare) {
        echo "Объект класса " . get_class($object)
            . ". Площадь: " . $object->getSquare();
    } else {
        echo "Объект класса " . get_class($object)
            . " не реализует интерфейс CalculateSquare.";
    }

    echo "<br>";
}

// Проверка работы

$square = new Square(5);
$circle = new Circle(3);
$triangle = new Triangle(4, 6);

printSquareInfo($square);
printSquareInfo($circle);
printSquareInfo($triangle);

?>