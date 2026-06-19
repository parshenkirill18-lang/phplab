<?php
/**
 * Рекурсивный парсер и вычислитель математических выражений.
 *
 * Поддерживает:
 *   + - * /            — базовые операции
 *   ( )                — скобки, в т.ч. отрицательные типа -(2+3)
 *   ^                  — возведение в степень
 *   sqrt(x)            — квадратный корень
 *   ln(x)              — натуральный логарифм
 *   log(x)             — десятичный логарифм
 *   x!                 — факториал
 *   pi, e              — математические константы
 *   унарный минус       — например -5, -(3+2)
 *   десятичные дроби    — 3.14
 *
 * Реализовано через рекурсивный спуск (recursive descent parser):
 * каждый уровень грамматики — отдельная функция, которая для
 * вычисления подвыражений рекурсивно вызывает саму себя или
 * функцию следующего уровня приоритета.
 *
 * Грамматика (от низкого приоритета к высокому):
 *   expression  := term (('+' | '-') term)*
 *   term        := factor (('*' | '/') factor)*
 *   factor      := power ('^' power)*
 *   power       := unary ('!')?
 *   unary       := ('-' unary) | primary
 *   primary     := number | constant | '(' expression ')'
 *                  | 'sqrt' '(' expression ')'
 *                  | 'ln'   '(' expression ')'
 *                  | 'log'  '(' expression ')'
 */

class CalcException extends \Exception {}

class ExpressionEvaluator
{
    private string $expr;
    private int $pos;
    private int $len;

    public function evaluate(string $expression): float
    {
        // убираем пробелы, заменяем запятую на точку (десятичный разделитель)
        $this->expr = str_replace([' ', ','], ['', '.'], $expression);
        $this->pos  = 0;
        $this->len  = strlen($this->expr);

        if ($this->expr === '') {
            throw new CalcException('Пустое выражение.');
        }

        $result = $this->parseExpression();

        if ($this->pos < $this->len) {
            throw new CalcException('Некорректный символ в позиции ' . $this->pos . ': "' . $this->expr[$this->pos] . '".');
        }

        if (is_nan($result) || is_infinite($result)) {
            throw new CalcException('Результат вычисления не является числом (деление на ноль или некорректная операция).');
        }

        return $result;
    }

    // expression := term (('+' | '-') term)*
    private function parseExpression(): float
    {
        $value = $this->parseTerm();

        while (true) {
            $ch = $this->peek();
            if ($ch === '+') {
                $this->pos++;
                $value = $value + $this->parseTerm();
            } elseif ($ch === '-') {
                $this->pos++;
                $value = $value - $this->parseTerm();
            } else {
                break;
            }
        }

        return $value;
    }

    // term := factor (('*' | '/') factor)*
    private function parseTerm(): float
    {
        $value = $this->parseFactor();

        while (true) {
            $ch = $this->peek();
            if ($ch === '*') {
                $this->pos++;
                $value = $value * $this->parseFactor();
            } elseif ($ch === '/') {
                $this->pos++;
                $divisor = $this->parseFactor();
                if ($divisor == 0) {
                    throw new CalcException('Деление на ноль.');
                }
                $value = $value / $divisor;
            } else {
                break;
            }
        }

        return $value;
    }

    // factor := power ('^' power)*           (право-ассоциативно)
    private function parseFactor(): float
    {
        $value = $this->parsePower();

        if ($this->peek() === '^') {
            $this->pos++;
            // правоассоциативность: 2^3^2 = 2^(3^2), поэтому рекурсивно вызываем parseFactor
            $exponent = $this->parseFactor();
            $value = pow($value, $exponent);
        }

        return $value;
    }

    // power := unary ('!')?
    private function parsePower(): float
    {
        $value = $this->parseUnary();

        if ($this->peek() === '!') {
            $this->pos++;
            $value = $this->factorial($value);
        }

        return $value;
    }

    // unary := ('-' unary) | primary
    private function parseUnary(): float
    {
        if ($this->peek() === '-') {
            $this->pos++;
            return -$this->parseUnary();   // рекурсивный вызов самого себя
        }
        if ($this->peek() === '+') {
            $this->pos++;
            return $this->parseUnary();
        }
        return $this->parsePrimary();
    }

    // primary := number | constant | '(' expression ')' | func '(' expression ')'
    private function parsePrimary(): float
    {
        $ch = $this->peek();

        // скобки — рекурсивный вызов parseExpression
        if ($ch === '(') {
            $this->pos++;
            $value = $this->parseExpression();
            $this->expect(')');
            return $value;
        }

        // числа (целые и дробные)
        if ($ch !== null && (ctype_digit($ch) || $ch === '.')) {
            return $this->parseNumber();
        }

        // функции и константы (буквенные идентификаторы)
        if ($ch !== null && ctype_alpha($ch)) {
            return $this->parseIdentifier();
        }

        throw new CalcException('Ожидалось число, скобка или функция в позиции ' . $this->pos . '.');
    }

    private function parseNumber(): float
    {
        $start = $this->pos;
        while ($this->pos < $this->len && (ctype_digit($this->expr[$this->pos]) || $this->expr[$this->pos] === '.')) {
            $this->pos++;
        }
        $numStr = substr($this->expr, $start, $this->pos - $start);
        if ($numStr === '' || $numStr === '.') {
            throw new CalcException('Некорректное число в позиции ' . $start . '.');
        }
        return (float) $numStr;
    }

    private function parseIdentifier(): float
    {
        $start = $this->pos;
        while ($this->pos < $this->len && ctype_alpha($this->expr[$this->pos])) {
            $this->pos++;
        }
        $name = substr($this->expr, $start, $this->pos - $start);

        switch ($name) {
            case 'pi':
                return M_PI;
            case 'e':
                return M_E;
            case 'sqrt':
                $this->expect('(');
                $arg = $this->parseExpression();
                $this->expect(')');
                if ($arg < 0) {
                    throw new CalcException('Нельзя извлечь корень из отрицательного числа.');
                }
                return sqrt($arg);
            case 'ln':
                $this->expect('(');
                $arg = $this->parseExpression();
                $this->expect(')');
                if ($arg <= 0) {
                    throw new CalcException('Логарифм определён только для положительных чисел.');
                }
                return log($arg);
            case 'log':
                $this->expect('(');
                $arg = $this->parseExpression();
                $this->expect(')');
                if ($arg <= 0) {
                    throw new CalcException('Логарифм определён только для положительных чисел.');
                }
                return log10($arg);
            default:
                throw new CalcException('Неизвестная функция или константа: "' . $name . '".');
        }
    }

    // рекурсивное вычисление факториала
    private function factorial(float $n): float
    {
        if ($n < 0) {
            throw new CalcException('Факториал отрицательного числа не определён.');
        }
        if (abs($n - round($n)) > 1e-9) {
            throw new CalcException('Факториал определён только для целых чисел.');
        }
        $n = (int) round($n);
        if ($n > 170) {
            throw new CalcException('Число слишком велико для вычисления факториала.');
        }
        return $this->factorialRecursive($n);
    }

    private function factorialRecursive(int $n): float
    {
        if ($n <= 1) {
            return 1;
        }
        return $n * $this->factorialRecursive($n - 1);   // рекурсивный вызов
    }

    private function peek(): ?string
    {
        return $this->pos < $this->len ? $this->expr[$this->pos] : null;
    }

    private function expect(string $char): void
    {
        if ($this->peek() !== $char) {
            throw new CalcException('Ожидался символ "' . $char . '" в позиции ' . $this->pos . '.');
        }
        $this->pos++;
    }
}
