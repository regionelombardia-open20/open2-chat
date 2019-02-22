<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\chat\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationWidgets;
use lispa\amos\dashboard\models\AmosWidgets;

/**
 * Class m180917_170759_add_widget_chat_assistance
 */
class m180917_170759_add_widget_chat_assistance extends AmosMigrationWidgets
{

    /**
     * @inheritdoc
     */
    protected function initWidgetsConfs()
    {
        $this->widgets = [
            [
                'classname' => \lispa\amos\chat\widgets\icons\WidgetIconChatAssistance::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => 'chat',
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => null,
                'default_order' => 55,
                'dashboard_visible' => 0,
            ]
        ];
    }
}
