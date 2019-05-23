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
use lispa\amos\core\widget\WidgetAbstract;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\chat\AmosChat;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class WidgetIconChatAssistance
 * @package lispa\amos\chat\widgets\icons
 */
class WidgetIconChatAssistance extends WidgetIcon
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $paramsClassSpan = [
            'bk-backgroundIcon',
            'color-primary'
        ];

        $this->setLabel(AmosChat::tHtml('amoschat', 'Assistenza'));
        $this->setDescription(AmosChat::t('amoschat', 'Hai bisogno di assistenza?'));

        if (!empty(\Yii::$app->params['dashboardEngine']) && \Yii::$app->params['dashboardEngine'] == WidgetAbstract::ENGINE_ROWS) {
            $this->setIconFramework(AmosIcons::IC);
            $this->setIcon('assistenza');
            $paramsClassSpan = [];
        } else {
            $this->setIcon('comments-o');
        }

        $amosChat = AmosChat::getInstance();

        $this->setUrl(['/messages', 'contactId' => $amosChat->assistanceUserId]);
        $this->setCode('CHAT');
        $this->setModuleName('chat');
        $this->setNamespace(__CLASS__);

        $this->setClassSpan(
            ArrayHelper::merge(
                $paramsClassSpan
            )
        );

        $this->setBulletCount(
            $this->makeBulletCounter(Yii::$app->getUser()->getId())
        );
    }

    /**
     * 
     * @param type $user_id
     * @return type
     */
    public function makeBulletCounter($user_id = null)
    {
        return Message::find()
            ->andWhere([
                'is_new' => true,
                'receiver_id' => $user_id,
                'is_deleted_by_receiver' => false
            ])
            ->asArray()
            ->count();
    }

    /**
     * Aggiunge all'oggetto container tutti i widgets recuperati dal controller del modulo
     * 
     * @return array
     */
    public function getOptions()
    {
        return ArrayHelper::merge(
                parent::getOptions(),
                ['children' => []]
        );
    }

    /**
     * 
     * @return boolean
     */
    public function isVisible()
    {
        if ($return = \Yii::$app->getUser()->can($this->getWidgetPermission())) {
            if (\Yii::$app->getModule('chat')->assistanceUserId != Yii::$app->user->id) {
                return true;
            }
        }

        return false;
    }

}
