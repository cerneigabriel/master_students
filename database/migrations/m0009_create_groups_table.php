<?php

use MasterStudents\Core\Migration;
use Spiral\Database\Injection\Fragment;

class m0009_create_groups_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("groups")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->integer("speciality_id")->nullable(false);
            $schema->string("name", 50)->nullable(false);
            $schema->string("year")->nullable(false);

            $schema->timestamp("created_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));
            $schema->timestamp("updated_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));

            return $schema;
        }
    }

    public function down()
    {
        $this->db->table("groups")->drop();
    }
}

// After migrating tables, you'll need some references between them, add these lines of code will help you pass through this challenge.
// SET FOREIGN_KEY_CHECKS=0;
// ALTER TABLE `groups` ADD  CONSTRAINT `user_group_fk` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
// SET FOREIGN_KEY_CHECKS=1