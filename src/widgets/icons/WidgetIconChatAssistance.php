<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\chat
 * @category   CategoryName
 */

namespace lispa\amos\chat\widgets\icons;

use lispa\amos\chat\models\Message;
use lispa\amos\core\widget\WidgetIcon;
use Yii;
use yii\helpers\ArrayHelper;
use lispa\amos\chat\AmosChat;

/**
 * Class WidgetIconChatAssistance
 * @package lispa\amos\chat\widgets\icons
 */
class WidgetIconChatAssistance extends WidgetIcon
{
    /**
     * @return array
     */
    public function getOptions()
    {
        $options = parent::getOptions();

        //aggiunge all'oggetto container tutti i widgets recuperati dal controller del modulo
        return ArrayHelper::merge($options, ["children" => []]);
    }


    public function isVisible()
    {
        if ($return = \Yii::$app->getUser()->can($this->getWidgetPermission())) {
            if(\Yii::$app->getModule('chat')->assistanceUserId != Yii::$app->user->id) {
                return true;
            }
        }
            return false;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->setLabel(AmosChat::tHtml('amoschat', 'Assistenza'));
        $this->setDescription(AmosChat::t('amoschat', 'Hai bisogno di assistenza?'));

        $this->setIcon('comments-o');
        //$this->setIconFramework('');
        $amosChat = AmosChat::getInstance();

        $this->setUrl(['/messages', 'contactId' => $amosChat->assistanceUserId ]);
        $this->setCode('CHAT');
        $this->setModuleName('chat');
        $this->setNamespace(__CLASS__);
        $bulletCount = Message::find()->andWhere([
            'is_new' => true,
            'receiver_id' => Yii::$app->getUser()->getId(),
            'is_deleted_by_receiver' => false
        ])->count();
        if ($bulletCount > 0) {
            $this->setBulletCount($bulletCount);
        }

        $this->setClassSpan(ArrayHelper::merge($this->getClassSpan(), [
            'bk-backgroundIcon',
            'color-primary'
        ]));
    }
}