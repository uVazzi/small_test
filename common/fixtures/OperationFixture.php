<?php

namespace common\fixtures;


use yii\test\ActiveFixture;

class OperationFixture extends ActiveFixture
{
    public $modelClass = 'common\models\domains\Operation';
    public $dataFile = '@common/fixtures/data/operation.php';
}