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

namespace open20\amos\chat\models\search;

use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * Class ConversationQuery
 * @package open20\amos\chat\models\search
 */
class ConversationQuery extends ActiveQuery
{
    public function init()
    {
        parent::init();
        $this->alias('c');
        $this->select([
            'last_message_id' => new Expression('MAX([[c.id]])'),
            'contact_id' => new Expression('IF([[sender_id]] = :userId, [[receiver_id]], [[sender_id]])')
        ])
            ->innerJoin('user_profile profile1', 'profile1.user_id = receiver_id AND profile1.deleted_at IS NULL')
            ->innerJoin('user_profile profile2', 'profile2.user_id = sender_id AND profile2.deleted_at IS NULL')
            ->andWhere(['or',
                ['receiver_id' => new Expression(':userId'), 'is_deleted_by_receiver' => false],
                ['sender_id' => new Expression(':userId'), 'is_deleted_by_sender' => false],
            ])
            ->andWhere(['profile1.attivo' => 1])
            ->andWhere(['profile2.attivo' => 1])
            ->groupBy(['contact_id']);
    }

    /**
     * @param $userId
     * @return $this
     */
    public function forUser($userId)
    {
        return $this->addParams(['userId' => $userId]);
    }
}
