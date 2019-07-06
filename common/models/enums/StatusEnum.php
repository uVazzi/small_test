<?php
namespace common\models\enums;

use yii2mod\enum\helpers\BaseEnum;


class StatusEnum extends BaseEnum
{
    const APPLY = 1;
    const REGISTERED = 2;
    const CONFIRM = 3;
    const APPROVED = 4;
    const SPECIAL = 5;

    public static $list = [
        self::APPLY => 'Подал заявку',
        self::REGISTERED => 'Зарегистрирован',
        self::CONFIRM => 'Подтверждён',
        self::APPROVED => 'Одобрен',
        self::SPECIAL => 'Особый',
    ];
}