<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\chat
 * @author    Aria S.p.A. <protocollo@pec.ariaspa.it>
 * @license   GNU General Public License v3.0 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @link      https://www.ariaspa.it/
 *
 * This file is part of OPEN 2.0.
 *
 * OPEN 2.0 is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OPEN 2.0 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OPEN 2.0. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * @var array $settings
 * @var string $msgOwnerClass
 * @var int $key
 * @var array $model
 * @var bool $viewNewMessagesRow
 * @var int $newMessagesCount
 */

use open20\amos\chat\AmosChat;

?>
<?php if (isset($viewNewMessagesRow) && $viewNewMessagesRow): ?>
    <div id="new-messages-row">
        <?php if ($newMessagesCount > 1): ?>
            <?= $newMessagesCount . ' ' . AmosChat::t('amoschat', 'messaggi non letti') ?>
        <?php else: ?>
            <?= $newMessagesCount . ' ' . AmosChat::t('amoschat', 'messaggio non letto') ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
<div class="item-chat nop <?= $settings['itemCssClass'] ?> <?= $msgOwnerClass ?>" data-key="<?= $key ?>">
    <?php if(\Yii::$app->getModule('chat')->enableForwardMessage && !empty(\Yii::$app->getModule('chat')->userIdForwardMessage) && $msgOwnerClass == 'others' && Yii::$app->user->can('ADMIN')) {?>
        <div class="forward-message">
            <a href="" data-pjax="0" class="forward-button btn btn-navigation-primary">Forward message to >></a>
<!--            <a href="" data-pjax="0" class="forward-button"><span>--><?php //echo \open20\amos\core\icons\AmosIcons::show('mail-reply-all', [
//                        'class' => 'am-2 flipped'
//                    ]); ?><!--</span> </a>-->
            <?php $arrIdUser = \Yii::$app->getModule('chat')->userIdForwardMessage?>
            <?= \yii\helpers\Html::dropDownList('message-to-forward-'.$model['messageId'], null,
                \yii\helpers\ArrayHelper::map(\open20\amos\chat\models\base\User::find()->andWhere(['id' => $arrIdUser])->all(), 'id', 'username'),
                [
                        'class' => 'form-control select',
                        'prompt' => 'Select...',
                        'data-key' => $model['messageId'],
                        'style' => 'display:none; margin-bottom:4px; width:auto; margin-right:auto;'
                ]) ?>
        </div>
    <?php } ?>
    <div class="text-msg-chat"><?= Yii::$app->getFormatter()->asRaw($model['text']); ?></div>
    <p><?= $model['date'] ?></p>
</div>