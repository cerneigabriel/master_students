<?php

use MasterStudents\Core\Migration;
use Spiral\Database\Injection\Fragment;

class m0008_create_specialities_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("specialities")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->integer("language_id")->nullable(false);
            $schema->string("name")->nullable(false);
            $schema->string("abbreviation")->nullable(false);
            $schema->string("duration")->nullable(false);

            $schema->timestamp("created_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));
            $schema->timestamp("updated_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));

            return $schema;
        }
    }

    public function down()
    {
        $this->db->table("specialities")->drop();
    }
}

// After migrating tables, you'll need some references between them, add these lines of code will help you pass through this challenge.
// SET FOREIGN_KEY_CHECKS=0;
// ALTER TABLE `groups` ADD  CONSTRAINT `user_group_fk` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
// SET FOREIGN_KEY_CHECKS=1