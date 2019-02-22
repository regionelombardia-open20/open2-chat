<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\chat
 * @category   CategoryName
 */

namespace lispa\amos\chat\models\base;

use lispa\amos\chat\AmosChat;
use lispa\amos\core\helpers\Html;
use Yii;
use yii\base\NotSupportedException;
use lispa\amos\admin\AmosAdmin;

/**
 * Class User
 * @package lispa\amos\chat\models\base
 *
 * @property \lispa\amos\admin\models\UserProfile $profile
 */
class User extends \lispa\amos\core\user\User
{
    private $_name;

    /**
     * @return static[]
     */
    public static function getAll($asArray = false)
    {
        if($asArray){
            return User::find()->with('userProfile')->asArray()->all();
        }
        else{
            return User::find()->with('userProfile')->all();
        }
    }

    /**
     * @inheritDoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException(get_called_class() . ' ' . AmosChat::t('amoschat', 'non supporta') . ' findIdentityByAccessToken().');
    }

    /**
     * @return null|\yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        if ($this->adminInstalled) {
            return $this->hasOne(AmosAdmin::instance()->createModel('UserProfile')->className(), ['user_id' => 'id']);
        } else
            return NULL;
    }

    /**
     * @return string
     */
    public function getName()
    {
        if ((null === $this->_name) && (isset($this->profile))) {
            $this->_name = $this->profile->cognome . ' ' . $this->profile->nome;
        }
        return $this->_name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return null|\yii\db\ActiveQuery
     */
    public function getProfile()
    {
        if ($this->adminInstalled) {
            return $this->hasOne(AmosAdmin::instance()->createModel('UserProfile')->className(), ['user_id' => 'id']);
        } else {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        $model = $this->profile;
        if(!$model){
            return $this->getDefaultProfileAvatar();
        }
        $roundImage = Yii::$app->imageUtility->getRoundImage($model);
        return  Html::img($model->getAvatarUrl('square_small'), [
                'class' => $roundImage['class'],
                'style' => "margin-left: " . $roundImage['margin-left'] . "%; margin-top: " . $roundImage['margin-top'] . "%;",
                'alt' => $model->getNomeCognome()
            ]
        );
    }

    protected function getDefaultProfileAvatar()
    {
        return Html::img("/img/defaultProfilo.png", ['width' => '50', 'class' => 'media-object avatar']);
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey)
    {
        return true;
    }
}
