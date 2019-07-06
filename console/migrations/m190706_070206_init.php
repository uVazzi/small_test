<?php

use yii\db\Migration;

/**
 * Class m190706_070206_init
 */
class m190706_070206_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('status', [
            'id' => $this->primaryKey(),
            'status_name' => $this->integer()->notNull(), // Enums
            'sending_messages' => $this->boolean()->defaultValue(0),
            'publication_info' => $this->boolean()->defaultValue(0),
            'view_info' => $this->boolean()->defaultValue(0),
        ]);

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'surname' => $this->string(50)->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'phone_number' => $this->string(20)->notNull()->unique(),
            'rating' => $this->integer()->defaultValue(0),
            'create_at' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk__user__status_id__to__status__id',
            '{{%user}}', 'status_id',
            '{{%status}}', 'id');

        $this->createTable('operation', [
            'id' => $this->primaryKey(),
            'assessment'=> $this->integer()->notNull(),
            'create_at' => $this->integer()->notNull(),
            'duration' => $this->string(),
            'type' => $this->integer(),
            'target' => $this->integer(),
            'user_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk__operation__user_id__to__user__id',
            '{{%operation}}', 'user_id',
            '{{%user}}', 'id');

    }

    public function down()
    {
        $this->dropForeignKey('fk__operation__user_id__to__user__id', '{{%operation}}');
        $this->dropTable('{{%operation}}');
        $this->dropForeignKey('fk__user__status_id__to__status__id', '{{%user}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%status}}');
    }
}
