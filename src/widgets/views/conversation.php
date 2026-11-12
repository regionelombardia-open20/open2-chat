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

use open20\amos\chat\AmosChat;
use open20\amos\chat\models\User;
use open20\amos\core\icons\AmosIcons;
use open20\amos\core\helpers\Html;

/**
 * @var array $model
 * @var int $key
 * @var array $settings
 * @var boolean $isCurrent
 * @var \open20\amos\chat\controllers\DefaultController $appController
 */

$appController = Yii::$app->controller;
$contactObj = User::findOne($model['contact']['id']);
$newMessagesCount = $model['newMessages']['count'];

?>
<a href="<?= '/messages/' . $model['contact']['id'] ?>" class="<?= $settings['itemCssClass'] ?>" data-pjax="0">
    <div
        class="item-chat nop <?= $newMessagesCount > 0 ? $settings['unreadCssClass'] : '' ?> <?= $isCurrent ? $settings['currentCssClass'] : '' ?>"
        data-key="<?= $key ?>" data-contact="<?= $model['contact']['id'] ?>"
        data-unreadurl="<?= $model['unreadUrl'] ?>"
        data-readurl="<?= $model['readUrl'] ?>"
        data-deleteurl="<?= $model['deleteUrl'] ?>"
        data-loadurl="<?= $model['loadUrl'] ?>"
        data-sendurl="<?= $model['sendUrl'] ?>">
        <div class="media">
            <div class="media-left">
                <div class="container-round-img-sm">
                    <?= $contactObj->getAvatar() ?>
                </div>
            </div>
            <div class="media-body">
                <h5 class="media-heading"><strong><?= $model['name'] ?></strong></h5>
                <!-- < ?= $model['contact']['username'] ?> -->
                <p class="time"> <?= $model['lastMessage']['date'] ?></p>


                <?php if ($newMessagesCount > 0): ?>
                    <span class="badge pull-right msg-new">
                        <?= $newMessagesCount ?>
                    </span>
                <?php endif; ?>

            </div>
        </div>
        <!--<div class="conversation-preview-text">
            <?php
/*            $result = Yii::$app->getFormatter()->asRaw($model['lastMessage']['text']);
            if( preg_match_all('/<img[^>]+>/i',$model['lastMessage']['text']) ){
                $result = AmosIcons::show('camera', ['class' => 'am-1']) . '<span> foto</span>';
            }
            */?>
            < ?= $result; ?>
        </div>-->

        <ul class="action-list">
            <li>
                    <span class="close delete_btn" title="<?= AmosChat::t('amoschat', 'Archivia') ?>">
                        <small aria-hidden="true">
                            <?= AmosIcons::show('delete', ['class' => 'am-lg']) ?>
                        </small>
                    </span>
            </li>
        </ul>
    </div>
</a>