<?php

namespace common\fixtures;


use yii\test\ActiveFixture;

class StatusFixture extends ActiveFixture
{
    public $modelClass = 'common\models\domains\Status';
    public $dataFile = '@common/fixtures/data/status.php';
}