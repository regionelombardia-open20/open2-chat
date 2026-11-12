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

use open20\amos\core\helpers\Html;

$avatar = '';
if (isset($model->profile)) {
$modelProfile =  $model->profile;
$avatar = $modelProfile->getAvatarUrl('square_small');
//$avatar = $model->profile->getAvatarUrl('small');
//$avatar_id = $model->profile->avatar_id;
}
?>
<a href="<?= '/messages/' . $model->id ?>">
    <div class="item-chat media nop" data-key=""
         data-user-contact="<?= $model->id ?>">
        <div class="media-left">
            <div class="container-round-img">
                <?= Html::img($modelProfile->getAvatarUrl('square_small'), [
                    'class' => Yii::$app->imageUtility->getRoundRelativeImage($modelProfile)['class'],
                    'alt' => $modelProfile->id
                ]) ?>
            </div>
        </div>
        <div class="media-body">
            <h5 class="media-heading"><strong><?= $model->name ?></strong></h5>
            <?= $model->username ?>
        </div>
    </div>
</a>
