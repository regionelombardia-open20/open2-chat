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

use open20\amos\core\helpers\Html;
use open20\amos\chat\assets\AmosChatAsset;
use yii\data\ActiveDataProvider;
use yii\web\View;

$assetBundle = AmosChatAsset::register($this);
?>

<div class="grid-item">
    <div class="box-widget chat-assistance-widget">
        <div class="box-widget-toolbar row nom">
            <h2 class="box-widget-title col-xs-10 nop"><?=$widget->titleWidget?></h2>
        </div>
        <section>
            <?= Html::img(!empty($widget->urlImage) ? $widget->urlImage : $assetBundle->baseUrl.'/img/info_chat.jpg', ['alt' => 'Scrivici per maggiori informazioni']) ?>
            <?= Html::a($widget->buttonText,
                [
                    '/chat/default/chat-with-assistance','user_id' => $widget->assistanceUserId,
                    'url' => $url,
                    'idchatAssistance' => $widget->assistanceWidgetId
                ],
                ['class' => 'btn btn btn-navigation-secondary', 'title' => $widget->buttonText]); ?>
        </section>
    </div>
</div>
