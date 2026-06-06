<?php
$username = htmlspecialchars($_GET['username'] ?? 'Гость');

$title = 'Страница приветствия';
$content = "<p>Привет, <strong>{$username}</strong>!</p>";

require 'templates/layout.php';