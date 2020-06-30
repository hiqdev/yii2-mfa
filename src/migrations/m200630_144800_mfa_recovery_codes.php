<?php

use yii\db\Migration;

/**
 * Class m200630_144800_mfa_recovery_codes
 */
class m200630_144800_mfa_recovery_codes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%mfa_recovery_codes}}',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer(11)->notNull(),
                'code' => $this->string(255),
            ],
            'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'
        );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mfa_recovery_codes}}');

        return true;
    }
}
