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
use yii\db\ActiveQuery;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/**
 * Class Conversation
 * @package open20\amos\chat\models
 *
 * @property-read User contact
 */
class Conversation extends \open20\amos\chat\models\base\Conversation
{
    /**
     * @inheritDoc
     */
    protected static function baseQuery($userId)
    {
        return parent::baseQuery($userId)->with(['newMessages', 'contact.profile']);
    }

    /**
     * @return ActiveQuery
     */
    public function getContact()
    {
        return $this->hasOne(\open20\amos\chat\models\User::className(), ['id' => 'contact_id']);
    }

    /**
     * @inheritDoc
     */
    public function fields()
    {
        return [
            'lastMessage' => function ($model) {
                return [
                    'text' => StringHelper::truncate($model['lastMessage']['text'], 120, '...', null, true),
                    'date' => static::formatDate($model['lastMessage']['created_at']),
                    'senderId' => $model['lastMessage']['sender_id']
                ];
            },
            'newMessages' => function ($model) {
                return [
                    'count' => count($model['newMessages'])
                ];
            },
            'contact' => function ($model) {
                return $model['contact'];
            },
            'profile' => function ($model) {
                $profile = null;
                $contact = $model->contact;
                if(!is_null($contact)){
                    $profile = $contact->profile;
                }
                return $profile;
            },
            'name' => function ($model) {
                $name = "";
                $contact = $model->contact;
                if(!is_null($contact)){
                    $name = $contact->name;
                }
                return $name;
            },
            'loadUrl',
            'sendUrl',
            'deleteUrl',
            'readUrl',
            'unreadUrl',
        ];
    }

    public static function formatDate($value)
    {
        $today = date_create()->setTime(0, 0, 0);
        $date = date_create($value)->setTime(0, 0, 0);
        if ($today == $date) {
            $formatted = \Yii::$app->formatter->asTime($value, 'short');
        } elseif ($today->getTimestamp() - $date->getTimestamp() == 24 * 60 * 60) {
            $formatted = AmosChat::tHtml('amoschat', 'Ieri');
        } elseif ($today->format('W') == $date->format('W') && $today->format('Y') == $date->format('Y')) {
            $formatted = \Yii::$app->formatter->asDate($value, 'php:l');
        } elseif ($today->format('Y') == $date->format('Y')) {
            $formatted = \Yii::$app->formatter->asDate($value, 'php:d F');
        } else {
            $formatted = \Yii::$app->formatter->asDate($value, 'medium');
        }

        return $formatted;
    }

    public function getLoadUrl()
    {
        return Url::to(['messages', 'contactId' => $this->contact_id]);
    }

    public function getSendUrl()
    {
        return Url::to(['create-message', 'contactId' => $this->contact_id]);
    }

    public function getDeleteUrl()
    {
        return Url::to(['delete-conversation', 'contactId' => $this->contact_id]);
    }

    public function getReadUrl()
    {
        return Url::to(['mark-conversation-as-read', 'contactId' => $this->contact_id]);
    }

    public function getUnreadUrl()
    {
        return Url::to(['mark-conversation-as-unread', 'contactId' => $this->contact_id]);
    }
}