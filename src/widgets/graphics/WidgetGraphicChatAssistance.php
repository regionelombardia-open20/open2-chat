<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\chat
 * @category   CategoryName
 */

namespace lispa\amos\chat\widgets\graphics;

use lispa\amos\chat\AmosChat;
use lispa\amos\core\module\BaseAmosModule;
use lispa\amos\core\widget\WidgetGraphic;
use yii\helpers\Url;
use Yii;

/**
 * Class WidgetGraphicChatAssistance
 * @package lispa\amos\chat\widgets\graphics
 */
class WidgetGraphicChatAssistance extends WidgetGraphic
{

    public $titleWidget = '';
    public $urlImage = '';
    public $assistanceUserId = '';
    public $buttonText = '';
    public $welcome_message = '';

    public $assistanceWidgetId = '';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $isScope = false;
        $this->titleWidget = AmosChat::t('amoschat','#widget_graph_chat_assist_title');
        $this->buttonText = AmosChat::t('amos_chat', '#widget_graph_chat_assist_btn_text');

        $moduleCwh = \Yii::$app->getModule('cwh');
        if(isset($moduleCwh)){
            $scope = $moduleCwh->getCwhScope();
            if(!empty($scope) && isset($scope['community'])){

                $moduleChat = \Yii::$app->getModule('chat');
                if(!empty($moduleChat)){
                    if(!empty($moduleChat->assistenzaChatCommunity)){
                        foreach ($moduleChat->assistenzaChatCommunity as $communityId=>$conf){
                            $this->assistanceWidgetId = $communityId;
                            $explode = explode('-',$communityId);
                            $id = end($explode);
                            if($id == $scope['community']){
                                if(!empty($conf['titleWidget'])) {
                                    $this->titleWidget = $conf['titleWidget'];
                                }
                                if(!empty($conf['urlImage'])) {
                                    $this->urlImage = $conf['urlImage'];
                                }
                                if(!empty($conf['btnText'])) {
                                    $this->buttonText = $conf['btnText'];
                                }

                                if(!empty($conf['welcome_message'])) {
                                    $this->welcome_message = $conf['welcome_message'];
                                }
                                $this->assistanceUserId = $conf['assistanceUserId'];

                                $isScope = true;
                                break;
                            }
                        }
                    }
                }
            }
        }
        $this->setCode('CHAT_ASSISTANCE_GRAPHIC');
        $this->setLabel($this->titleWidget);
        $this->setDescription($this->titleWidget);
        return $isScope;
    }

    /**
     * @inheritdoc
     */
    public function getHtml()
    {
        if (!empty($this->assistanceUserId) && ($this->assistanceUserId != Yii::$app->user->id)) {
            $url = Url::to(['/messages', 'contactId' => $this->assistanceUserId]);
            return $this->render('chat-assistance', [
                'url' => $url,
                'widget' => $this,
            ]);
        }
    }

}
