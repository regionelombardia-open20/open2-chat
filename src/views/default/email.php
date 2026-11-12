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
use open20\amos\core\helpers\Html;

/**
 * @var \open20\amos\admin\models\UserProfile $contactProfile
 * @var \open20\amos\chat\models\Message $message
 */

$module = Yii::$app->getModule('chat');
?>

<div>
    <div style="box-sizing:border-box;">
        <div style="padding:5px 10px;background-color: #F2F2F2;text-align:center;">
            <h1 style="color:#000000;font-size:1.5em;margin:0;">
                <?= $contactProfile->getNomeCognome() . " " . AmosChat::t('amoschat', 'sent you a private message') ?>
            </h1>
        </div>
        <div style="border:1px solid #cccccc;padding:10px;margin-bottom:10px;background-color:#ffffff;margin-top:20px;text-align: center;">
            <div>
                <?= isset($message)? \yii\helpers\HtmlPurifier::process($message->text,[
                        'HTML.Allowed' => isset($module)? $module->emailMessageContentAllowedTag: '',
                        'HTML.SafeIframe'         => true,
                ]): '' ?>
            </div>
            <h2 style="font-size:2em;line-height: 1;"><?= Html::a(
                    AmosChat::t('amoschat', "#mail_link_text"),
                    \Yii::$app->urlManager->createAbsoluteUrl('/messages/' . $contactProfile->user_id),
                    ['style' => 'color: #297A38;'])
                ?>
            </h2>
        </div>
    </div>
    <!--<div>
        <div style="margin-top:20px; display: flex; padding: 10px;">
            <div
                style="width: 50px; height: 50px; overflow: hidden;-webkit-border-radius: 50%; -moz-border-radius: 50%; border-radius: 50%;float: left;">
                <?php /*echo \open20\amos\admin\widgets\UserCardWidget::widget([
                    'model' => $contactProfile,
                    'onlyAvatar' => true,
                    'absoluteUrl' => true
                ]) ?>
            </div>
            <div style="margin: 15px 0 0 20px;">
                <?= AmosChat::t('amoschat', "#sent_by") ?> <span
                    style="font-weight: 900;"><?= $contactProfile->getNomeCognome() ?></span>
            </div>
        </div>
        <div style="width:100%;margin-top:30px">
            <p><?= AmosChat::t('amoschat', '#mail_footer_text') */?></p>
        </div>
    </div>-->
</div>


