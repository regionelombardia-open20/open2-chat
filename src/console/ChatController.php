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

namespace open20\amos\chat\console;

use open20\amos\chat\AmosChat;
use open20\amos\chat\models\Message;
use open20\amos\chat\models\User;
use open20\amos\admin\models\UserProfile;
use Yii;

/**
 * Class ChatController
 * @package open20\amos\chat\console
 */
class ChatController extends \yii\console\Controller
{
    public function actionSendMails()
    {
        $data = Message::find()
            ->addSelect([
                'receiver_id',
                'sender_id',
                "CONCAT(senderUserProfile.nome, ' ', senderUserProfile.cognome) AS senderCompleteName",
                'receiverUser.email AS receiverEmail',
                'COUNT(*) AS msgCount'
            ])
            ->leftJoin(User::tableName() . ' AS receiverUser', 'receiver_id = receiverUser.id')
            ->leftJoin(UserProfile::tableName() . ' AS senderUserProfile', 'sender_id = senderUserProfile.id')
            ->andWhere([
                'is_new' => true,
                'is_deleted_by_receiver' => false
            ])
            ->groupBy(['receiver_id', 'sender_id'])
            ->asArray()->all();

        foreach ($data as $userData) {
            $subject = AmosChat::t('amoschat','Nuovo messaggio su ') . Yii::$app->name;
            Yii::$app->getMailer()
                ->compose(
                    [
                        'html' => '@vendor/open20/amos-chat/src/mail/new-message/html',
                        'text' => '@vendor/open20/amos-chat/src/mail/new-message/text'
                    ], [
                    'userData' => $userData,
                    'subject' => $subject,
                ])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                ->setReplyTo([Yii::$app->params['supportEmail'] => Yii::$app->name])
                ->setTo($userData['receiverEmail'])
                ->setSubject($subject)
                ->send();
        }

        Yii::$app->end();
    }


}
