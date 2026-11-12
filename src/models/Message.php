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

namespace open20\amos\chat\models;

use open20\amos\chat\AmosChat;
use open20\amos\chat\controllers\DefaultController;
use Yii;
use yii\log\Logger;

/**
 * Class Message
 * @package open20\amos\chat\models
 */
class Message extends \open20\amos\chat\models\base\Message
{
    public $userIdForward = [];

    /**
     * @inheritDoc
     */
    public function fields()
    {
        return [
            'messageId' => 'id',
            'senderId' => 'sender_id',
            'text',
            'date' => function ($model) {
                return static::formatDate($model['created_at'])[1];
            },
            'when' => function ($model) {
                return static::formatDate($model['created_at'])[0];
            },
        ];
    }

    /**
     * @param $value
     * @return array
     */
    public static function formatDate($value)
    {
        $today = date_create()->setTime(0, 0, 0);
        $date  = date_create($value)->setTime(0, 0, 0);
        if ($today == $date) {
            $label = AmosChat::tHtml('amoschat', 'Oggi');
        } elseif ($today->getTimestamp() - $date->getTimestamp() == 24 * 60 * 60) {
            $label = AmosChat::tHtml('amoschat', 'Ieri');
        } elseif ($today->format('W') == $date->format('W') && $today->format('Y') == $date->format('Y')) {
            $label = Yii::$app->formatter->asDate($value, 'php:l');
        } elseif ($today->format('Y') == $date->format('Y')) {
            $label = Yii::$app->formatter->asDate($value, 'php:d F');
        } else {
            $label = Yii::$app->formatter->asDate($value, 'medium');
        }
        $formatted = Yii::$app->formatter->asTime($value, 'short');
        return [$label, $formatted];
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if(is_null($this->deleted_at)){ // Controllo aggiunto per evitare di mandare mail per messaggi già cancellati
            try {
                /** @var AmosChat $module */
                $module = Yii::$app->getModule('chat');

                if (!empty($module) && isset($module->immediateNotificationForce) && ($module->immediateNotificationForce == true)) {
                    $from = '';
                    if (isset(Yii::$app->params['email-assistenza'])) {
                        //use default platform email assistance
                        $from = Yii::$app->params['email-assistenza'];
                    }
                    $sender        = User::findOne($this->sender_id);
                    $senderProfile = $sender->profile;
                    $subject       = AmosChat::t('amoschat', 'You received a new private message');

                    /** @var DefaultController $controller */
                    $controller = new DefaultController('default', $module);
                    $text       = $controller->renderMailPartial('@vendor/open20/amos-chat/src/views/default/email',
                        [
                        'message' => $this,
                        'contactProfile' => $senderProfile
                        ], $this->receiver_id);

                $mailModule = Yii::$app->getModule('email');
                if (!is_null($mailModule)) {

                        /** @var \open20\amos\emailmanager\AmosEmail $mailModule */
                        $mailModule->send(
                            (!empty($module->defaultEmailSender) ? $module->defaultEmailSender : (!empty($from) ? $from : $sender->email)),
                            User::findOne($this->receiver_id)->email, $subject, $text
                        );
                    }
                }
            } catch (\Exception $exception) {
                Yii::getLogger()->log($exception->getMessage(), Logger::LEVEL_ERROR);
            }
            parent::afterSave($insert, $changedAttributes);
        }
    }
}
