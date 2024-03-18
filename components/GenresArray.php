<?php
namespace app\components;

use yii\base\Component;

class GenresArray extends Component
{
    public array $genres = [
        'Детектив' => 'Детектив',
        'Фентези' => 'Фентези',
        'Поэма' => 'Поэма',
        'Фантастика' => 'Фантастика',
        'Исторический' => 'Исторический',
    ];
}