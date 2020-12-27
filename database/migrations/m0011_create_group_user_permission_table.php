<?php

use MasterStudents\Core\Migration;
use Spiral\Database\Injection\Fragment;

class m0011_create_group_user_permission_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("group_user_permission")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->integer("group_user_id")->nullable(false);
            $schema->integer("permission_id")->nullable(false);

            $schema->timestamp("created_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));
            $schema->timestamp("updated_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));

            return $schema;
        }
    }

    public function down()
    {
        $this->db->table("group_user_permission")->drop();
    }
}

// After migrating tables, you'll need some references between them, add these lines of code will help you pass through this challenge.
// SET FOREIGN_KEY_CHECKS=0;
// ALTER TABLE `group_user_permission` ADD  CONSTRAINT `group_user_permission_fk` FOREIGN KEY (`group_id`) REFERENCES `groups`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;