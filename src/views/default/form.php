<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos-chat
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
use open20\amos\core\forms\TextEditorWidget;

$useEmoticon = AmosChat::instance()->enableEmoticonInRte;
?>
<?=
Html::beginForm('', 'post', [
    'id' => 'msg-form',
    'class' => ''
]);
?>

<label class="hidden" for="chat-message"><?= AmosChat::tHtml('amoschat', 'Messaggio') ?></label>

<?=
TextEditorWidget::widget([
    'name' => 'text',
    'options' => [
        'id' => 'chat-message',
        'class' => 'form-control send-message',
        'placeholder' => AmosChat::t('amoschat', 'Scrivi una risposta...')
    ],
    'clientOptions' => [
        'focus' => true,
        'buttons' => Yii::$app->controller->module->formRedactorButtons,
        'lang' => substr(Yii::$app->language, 0, 2),
        'toolbar' => ($useEmoticon ? "link image emoticons" : "link image"),
        'plugins' => ($useEmoticon ? ['autosave', 'emoticons'] : ['autosave']),
        'setup' => new yii\web\JsExpression('function(editor) {
                editor.on("change keyup", function(e){
                    //console.log("Saving");
                    //tinyMCE.triggerSave(); // updates all instances
                    editor.save();
                    $(editor.getElement()).trigger("change"); 
                });
            }')
    ]
])
?>
<?= Html::endForm(); ?>
