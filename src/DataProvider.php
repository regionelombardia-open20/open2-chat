<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\chat
 * @category   CategoryName
 */

namespace lispa\amos\chat;

use yii\base\Arrayable;
use yii\base\ArrayableTrait;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Class DataProvider
 * @package lispa\amos\chat
 */
class DataProvider extends ActiveDataProvider implements Arrayable
{
    use ArrayableTrait;

    /**
     * @inheritDoc
     */
    public function fields()
    {
        return [
            'totalCount',
            'keys',
            'models',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getModels()
    {
        return ArrayHelper::toArray(parent::getModels());
    }
}
