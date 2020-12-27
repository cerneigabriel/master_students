<?php

use MasterStudents\Core\Migration;
use Spiral\Database\Injection\Fragment;

class m0008_create_group_user_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("group_user")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->integer("group_id")->nullable(false);
            $schema->integer("user_id")->nullable(false);
            $schema->boolean("activated")->nullable(false)->defaultValue(false);

            $schema->timestamp("created_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));
            $schema->timestamp("updated_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));

            return $schema;
        }
    }

    public function down()
    {
        $this->db->table("group_user")->drop();
    }
}

// After migrating tables, you'll need some references between them, add these lines of code will help you pass through this challenge.
// SET FOREIGN_KEY_CHECKS=0;
// ALTER TABLE `group_user` ADD  CONSTRAINT `group_user_fk` FOREIGN KEY (`group_id`) REFERENCES `groups`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
// ALTER TABLE `group_user` ADD  CONSTRAINT `master_student_group_fk` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
// SET FOREIGN_KEY_CHECKS=1