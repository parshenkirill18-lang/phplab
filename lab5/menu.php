<?php

function menu($active = 'view')
{
    $items = [
        'view' => 'Просмотр',
        'add' => 'Добавление',
        'edit' => 'Редактирование',
        'delete' => 'Удаление'
    ];

    $html = '';

    foreach ($items as $key => $title) {

        $class = ($active == $key) ? 'select' : '';

        $html .= "<a class='$class' href='index.php?page=$key'>$title</a>";
    }

    return $html;
}