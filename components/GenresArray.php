<?php
namespace app\components;

/**
 * @property array $genres Массив жанров
 */

use yii\base\Component;

class GenresArray extends Component
{
    public $genres = [
        'Детектив' => 'Детектив',
        'Фентези' => 'Фентези',
        'Поэма' => 'Поэма',
        'Фантастика' => 'Фантастика',
        'Исторический' => 'Исторический',
    ];
}