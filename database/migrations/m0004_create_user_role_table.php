<?php

use MasterStudents\Core\Migration;
use Spiral\Database\ForeignKeyInterface;

class m0004_create_user_role_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("user_role")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->integer("user_id")->nullable(false);
            $schema->integer("role_id")->nullable(false);

            $schema->timestamp("created_at")->nullable(false);
            $schema->timestamp("updated_at")->nullable(false);

            return $schema;
        }
    }

    public function down()
    {
        $this->db->table("user_role")->drop();
    }
}

// After migrating tables, you'll need some references between them, add these lines of code will help you pass through this challenge.
// SET FOREIGN_KEY_CHECKS=0;
// ALTER TABLE `user_role` ADD  CONSTRAINT `user_fk` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
// ALTER TABLE `user_role` ADD  CONSTRAINT `role_fk` FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
// SET FOREIGN_KEY_CHECKS=1