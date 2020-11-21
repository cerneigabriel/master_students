<?php

use MasterStudents\Core\Migration;
use Spiral\Database\ForeignKeyInterface;

class m0005_create_role_permission_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("role_permission")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->integer("role_id")->nullable(false);
            $schema->integer("permission_id")->nullable(false);

            $schema->timestamp("created_at")->nullable(false);
            $schema->timestamp("updated_at")->nullable(false);

            return $schema;
        }
    }

    public function down()
    {
        $this->db->table("role_permission")->drop();
    }
}

// After migrating tables, you'll need some references between them, add these lines of code will help you pass through this challenge.
// SET FOREIGN_KEY_CHECKS=0;
// ALTER TABLE `role_permission` ADD  CONSTRAINT `role_permission_fk` FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
// ALTER TABLE `role_permission` ADD  CONSTRAINT `permission_role_fk` FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
// SET FOREIGN_KEY_CHECKS=1