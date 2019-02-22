<?php
use lispa\amos\core\migration\AmosMigrationWidgets;
use lispa\amos\dashboard\models\AmosWidgets;


/**
* Class m180327_162827_add_amos_widgets_een_archived*/
class m181022_143527_add_widget_chat_assistance extends AmosMigrationWidgets
{
    const MODULE_NAME = 'community';

    /**
    * @inheritdoc
    */
    protected function initWidgetsConfs()
    {
        $this->widgets = [
            [
                'classname' => \lispa\amos\chat\widgets\graphics\WidgetGraphicChatAssistance::className(),
                'type' => AmosWidgets::TYPE_GRAPHIC,
                'module' => self::MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'dashboard_visible' => 0,
                'sub_dashboard' => 1,
                'default_order' => 30,
            ]
        ];
    }
}
