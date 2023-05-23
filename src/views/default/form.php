<?php

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
