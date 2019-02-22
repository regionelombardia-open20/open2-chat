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
use lispa\amos\chat\AmosChat;
/**
 * @var \lispa\amos\chat\models\User $model
 * @var \lispa\amos\chat\controllers\DefaultController $appController
 * @var array $settings
 * @var int $key
 */

//check if the user contact is disabled
$disabled = false;
$disabledText = "";
if($disableByCommunityScope){
    $disabled = true;
    $disabledText = AmosChat::t('amoschat', '#disabled_community_scope');
}

if(!$disabled){ ?>
<a class="user-contacts-item" href="<?= '/messages/' . $model->id ?>">
<?php } ?>
    <div class="item-chat media nop <?= $settings['itemCssClass'] ?> <?=($disabled ? "user-disabled" : "")?>" data-key="<?= $key ?>"
         data-user-contact="<?= $model->id ?>" <?=($disabledText ? "title=\"$disabledText\"" : "")?>>
        <div class="media-left">
            <div class="container-round-img">
                <?= $model->getAvatar() ?>
            </div>
        </div>
        <div class="media-body">
            <h5 class="media-heading"><strong><?= $model->name ?></strong></h5>
            <!-- < ?= $model->username ?> -->
        </div>
    </div>
<?php if(!$disabled){ ?>
</a>
<?php } ?>