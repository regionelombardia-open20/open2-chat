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

use yii\db\Migration;

class m161026_140628_update_amoschat_role extends Migration
{
    const TABLE_AUTH_ITEM = '{{%auth_item}}';
    const TABLE_AUTH_ITEM_CHILD = '{{%auth_item_child}}';

    /**
     * Use this instead of function up().
     */
    public function safeUp()
    {
        try {
            $this->execute("SET foreign_key_checks = 0;");
            $this->update('tag_models_auth_items_mm', ['auth_item' => 'AMMINISTRATORE_CHAT'] , ['auth_item' => 'AMMINISRATORE_CHAT']);
            $this->update(self::TABLE_AUTH_ITEM, ['name' => 'AMMINISTRATORE_CHAT'] , ['name' => 'AMMINISRATORE_CHAT']);
            $this->update(self::TABLE_AUTH_ITEM_CHILD, ['parent' => 'AMMINISTRATORE_CHAT'] , ['parent' => 'AMMINISRATORE_CHAT']);
            $this->update(self::TABLE_AUTH_ITEM_CHILD, ['child' => 'AMMINISTRATORE_CHAT'] , ['child' => 'AMMINISRATORE_CHAT']);
            $this->execute("SET foreign_key_checks = 1;");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
            return false;
        }

        return true;
    }

    /**
     * Use this instead of function down().
     */
    public function safeDown()
    {
        echo "Down non esegue nessuna operazione.";
        return true;
    }
}
