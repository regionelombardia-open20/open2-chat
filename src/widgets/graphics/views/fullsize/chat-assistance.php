<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\chat
 * @category   CategoryName
 */

use lispa\amos\core\helpers\Html;
use lispa\amos\chat\assets\AmosChatAsset;
use yii\data\ActiveDataProvider;
use yii\web\View;

$assetBundle = AmosChatAsset::register($this);
?>

<div class="box-widget-header">
    <div class="box-widget-wrapper">
        <div class="box-widget-toolbar row nom">
            <h2 class="box-widget-title col-xs-10 nop"><?= $widget->titleWidget ?></h2>
        </div>
    </div>
</div>

<div class="box-widget chat-assistance-widget">
    <div class="list-items">
        <section>
            <?= Html::img(!empty($widget->urlImage) ? $widget->urlImage : $assetBundle->baseUrl . '/img/info_chat.jpg', ['alt' => 'Scrivici per maggiori informazioni']) ?>
            <?= Html::a($widget->buttonText,
                [
                    '/chat/default/chat-with-assistance', 'user_id' => $widget->assistanceUserId,
                    'url' => $url,
                    'idchatAssistance' => $widget->assistanceWidgetId
                ],
                ['class' => 'btn btn btn-navigation-secondary', 'title' => $widget->buttonText]); ?>
        </section>
    </div>
</div>
