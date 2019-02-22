<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\chat\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationPermissions;

/**
 * Class m180917_171235_add_widget_chat_assistance_permissions
 */
class m180917_171235_add_widget_chat_assistance_permissions extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => \lispa\amos\chat\widgets\icons\WidgetIconChatAssistance::className(),
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'description' => 'Permession to view the widget assistance conversion.',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_CHAT', 'BASIC_USER']
            ]
        ];
    }
}
