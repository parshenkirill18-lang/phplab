<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/CalculatorEngine.php';

// ── BACK: обработка запроса ──────────────────────────────────
// Согласно заданию: ввод приходит как POST, результат отдаётся через GET.
// Делаем редирект POST -> GET, чтобы результат отображался по GET-параметру.

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['expression'])) {
    $expr = trim((string) $_POST['expression']);
    header('Location: calculator.php?expression=' . urlencode($expr));
    exit;
}

$result = '';
$error  = '';
$inputExpr = '';

if (isset($_GET['expression']) && trim($_GET['expression']) !== '') {
    $inputExpr = trim($_GET['expression']);
    try {
        $calc = new ExpressionEvaluator();
        $value = $calc->evaluate($inputExpr);

        // аккуратное форматирование результата (без лишних нулей)
        if (abs($value - round($value)) < 1e-9 && abs($value) < 1e15) {
            $result = (string) (int) round($value);
        } else {
            $result = rtrim(rtrim(number_format($value, 10, '.', ''), '0'), '.');
        }
    } catch (CalcException $e) {
        $error = $e->getMessage();
    } catch (\Throwable $e) {
        $error = 'Ошибка вычисления выражения.';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор — Паршин К 251-3210</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, Helvetica, sans-serif; background: #fff; color: #111; font-size: 14px; min-height: 100vh; }

        .header { background: #000; }
        .header-inner { max-width: 980px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; justify-content: space-between; height: 54px; }
        .logo { font-size: 17px; font-weight: bold; color: #fff; text-decoration: none; }
        .nav { display: flex; gap: 4px; align-items: center; }
        .nav a { color: #bbb; text-decoration: none; font-size: 13px; padding: 7px 13px; }
        .nav a:hover { color: #fff; }
        .nav a.active { color: #fff; border-bottom: 2px solid #fff; }

        .wrap { max-width: 460px; margin: 36px auto; padding: 0 20px; }
        .page-title { font-size: 21px; margin-bottom: 16px; text-align: center; }

        .calc-card { background: #fff; border: 1px solid #ddd; padding: 18px; }

        .display { background: #000; color: #fff; padding: 16px 14px; margin-bottom: 12px; }
        .display-input { font-size: 14px; color: #999; min-height: 18px; text-align: right; word-break: break-all; font-family: 'Consolas', monospace; }
        .display-result { font-size: 28px; font-weight: bold; text-align: right; margin-top: 4px; font-family: 'Consolas', monospace; min-height: 34px; word-break: break-all; }

        .error-box { background: #fbeaea; color: #7a1a1a; border: 1px solid #e0b0b0; padding: 8px 12px; font-size: 12px; margin-bottom: 12px; }

        .keys { display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; }
        .key {
            border: 1px solid #ccc; background: #fafafa; color: #111;
            font-size: 16px; padding: 14px 0; cursor: pointer; text-align: center;
            font-family: inherit; transition: background .1s;
        }
        .key:hover { background: #eee; }
        .key:active { background: #ddd; }
        .key.op { background: #f0f0f0; font-weight: bold; }
        .key.op:hover { background: #e2e2e2; }
        .key.fn { background: #fff; color: #444; font-size: 13px; }
        .key.equals { background: #000; color: #fff; grid-column: span 2; }
        .key.equals:hover { background: #2a2a2a; }
        .key.clear { background: #900; color: #fff; }
        .key.clear:hover { background: #b00; }
        .key.wide { grid-column: span 2; }

        .extra-keys { display: grid; grid-template-columns: repeat(6, 1fr); gap: 6px; margin-bottom: 6px; }
        .extra-keys .key { font-size: 12px; padding: 10px 0; }

        .footer { background: #000; color: #888; text-align: center; padding: 14px; font-size: 12px; margin-top: 30px; }

        .hint { font-size: 11px; color: #999; text-align: center; margin-top: 12px; line-height: 1.6; }
    </style>
</head>
<body>

<header class="header">
    <div class="header-inner">
        <a href="." class="logo">Паршин К 251-3210</a>
        <nav class="nav">
            <a href="book">Каталог</a>
            <a href="calculator.php" class="active">Калькулятор</a>
            <a href="cart">Корзина</a>
        </nav>
    </div>
</header>

<div class="wrap">
    <div class="page-title">Калькулятор</div>

    <?php if ($error): ?>
        <div class="error-box">Ошибка: <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="calc-card">
        <div class="display">
            <div class="display-input" id="display-input">&nbsp;</div>
            <div class="display-result" id="display-result"><?= $result !== '' ? htmlspecialchars($result) : '0' ?></div>
        </div>

        <!-- дополнительные функции (бонус) -->
        <div class="extra-keys">
            <button type="button" class="key fn" onclick="appendVal('sqrt(')">√</button>
            <button type="button" class="key fn" onclick="appendVal('^')">xʸ</button>
            <button type="button" class="key fn" onclick="appendVal('!')">x!</button>
            <button type="button" class="key fn" onclick="appendVal('ln(')">ln</button>
            <button type="button" class="key fn" onclick="appendVal('log(')">log</button>
            <button type="button" class="key fn" onclick="backspace()">⌫</button>
        </div>
        <div class="extra-keys" style="margin-bottom:10px;">
            <button type="button" class="key fn" onclick="appendVal('pi')">π</button>
            <button type="button" class="key fn" onclick="appendVal('e')">e</button>
            <button type="button" class="key fn" onclick="appendVal('(')">(</button>
            <button type="button" class="key fn" onclick="appendVal(')')">)</button>
            <button type="button" class="key fn" onclick="appendVal('.')">.</button>
            <button type="button" class="key fn" onclick="appendVal('-')" style="grid-column:span 1">+/-</button>
        </div>

        <!-- основная клавиатура -->
        <div class="keys">
            <button type="button" class="key clear wide" onclick="clearAll()">C</button>
            <button type="button" class="key op" onclick="appendVal('/')">÷</button>
            <button type="button" class="key op" onclick="appendVal('*')">×</button>

            <button type="button" class="key" onclick="appendVal('7')">7</button>
            <button type="button" class="key" onclick="appendVal('8')">8</button>
            <button type="button" class="key" onclick="appendVal('9')">9</button>
            <button type="button" class="key op" onclick="appendVal('-')">−</button>

            <button type="button" class="key" onclick="appendVal('4')">4</button>
            <button type="button" class="key" onclick="appendVal('5')">5</button>
            <button type="button" class="key" onclick="appendVal('6')">6</button>
            <button type="button" class="key op" onclick="appendVal('+')">+</button>

            <button type="button" class="key" onclick="appendVal('1')">1</button>
            <button type="button" class="key" onclick="appendVal('2')">2</button>
            <button type="button" class="key" onclick="appendVal('3')">3</button>
            <button type="button" class="key equals" rowspan="2" onclick="calculate()" style="grid-row: span 2;">=</button>

            <button type="button" class="key wide" onclick="appendVal('0')">0</button>
            <button type="button" class="key" onclick="appendVal('.')">.</button>
        </div>

        <div class="hint">Поддерживается ввод с клавиатуры: цифры, + − * / ^ ( ) . Enter — вычислить, Backspace — стереть, Esc — очистить</div>
    </div>
</div>

<footer class="footer">Паршин К 251-3210</footer>

<!-- скрытая форма для отправки выражения на сервер (POST) -->
<form id="calc-form" method="POST" action="calculator.php" style="display:none;">
    <input type="hidden" name="expression" id="expression-field" value="">
</form>

<script>
// Поле пользовательского ввода заполняется и хранится на клиенте через JS.
var currentExpr = '';

// Если страница открыта с результатом (после GET-редиректа), восстановим выражение в верхнюю строку
var lastExpr = <?= json_encode($inputExpr) ?>;
if (lastExpr) {
    document.getElementById('display-input').textContent = lastExpr;
}

function renderInput() {
    var el = document.getElementById('display-input');
    el.textContent = currentExpr === '' ? '\u00A0' : currentExpr;
}

function appendVal(v) {
    currentExpr += v;
    renderInput();
}

function backspace() {
    currentExpr = currentExpr.slice(0, -1);
    renderInput();
}

function clearAll() {
    currentExpr = '';
    document.getElementById('display-result').textContent = '0';
    renderInput();
}

function calculate() {
    if (currentExpr.trim() === '') return;
    // отправляем пользовательский ввод на сервер как POST-параметр
    document.getElementById('expression-field').value = currentExpr;
    document.getElementById('calc-form').submit();
}

// ── Поддержка ввода с клавиатуры (бонус) ──────────────────────
document.addEventListener('keydown', function (e) {
    var key = e.key;

    if (/^[0-9.]$/.test(key)) {
        appendVal(key);
        e.preventDefault();
        return;
    }
    if (key === '+' || key === '-' || key === '*' || key === '/' || key === '^') {
        appendVal(key);
        e.preventDefault();
        return;
    }
    if (key === '(' || key === ')') {
        appendVal(key);
        e.preventDefault();
        return;
    }
    if (key === '!') {
        appendVal('!');
        e.preventDefault();
        return;
    }
    if (key === 'Enter' || key === '=') {
        calculate();
        e.preventDefault();
        return;
    }
    if (key === 'Backspace') {
        backspace();
        e.preventDefault();
        return;
    }
    if (key === 'Escape') {
        clearAll();
        e.preventDefault();
        return;
    }
    // p -> pi, чтобы было удобно с клавиатуры
    if (key.toLowerCase() === 'p') {
        appendVal('pi');
        e.preventDefault();
        return;
    }
});
</script>

</body>
</html>
