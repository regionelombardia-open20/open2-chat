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

use open20\amos\core\migration\AmosMigration;
use yii\rbac\Permission;

class m161026_140626_add_amoschat_role extends AmosMigration
{
    /**
     * Use this instead of function up().
     */
    public function safeUp()
    {
        // If you want to add permissions and roles. If you don't need this delete the code below.
        return $this->addAuthorizations();
    }

    /**
     * Use this instead of function down().
     */
    public function safeDown()
    {
        // If you want to remove permissions and roles. If you don't need this delete the code below.
        return $this->removeAuthorizations();
    }

    /**
     * Use this function to map permissions, roles and associations between permissions and roles. If you don't need to
     * to add or remove any permissions or roles you have to delete this method.
     */
    protected function setAuthorizations()
    {
        $this->authorizations = [
            [
                'name' => 'AMMINISTRATORE_CHAT',
                'type' => Permission::TYPE_ROLE,
                'description' => 'Ruolo del plugin chat',
                'ruleName' => null
            ],
            [
                'name' => \open20\amos\chat\widgets\icons\WidgetIconChat::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso per vedere il widget di accesso ai messaggi',
                'ruleName' => null,
                'parent' => ['AMMINISTRATORE_CHAT']
            ]
        ];
    }
}
