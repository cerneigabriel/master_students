<?php

use MasterStudents\Core\Migration;
use Spiral\Database\ForeignKeyInterface;

class m0003_create_sessions_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("sessions")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->integer("user_id")->nullable(false);
            $schema->boolean("active")->nullable(false)->defaultValue(false);
            $schema->string("token")->nullable(true);
            $schema->boolean("remember_token")->nullable(false)->defaultValue(false);
            $schema->json("data")->nullable(true);
            $schema->string("ip")->nullable(false);

            $schema->timestamp("created_at")->nullable(false);
            $schema->timestamp("updated_at")->nullable(false);

            $schema->index(["token"])->unique(true);

            return $schema;
        }
    }

    public function down()
    {
        $this->db->table("sessions")->drop();
    }
}

// After migrating tables, you'll need some references between them, add these lines of code will help you pass through this challenge.
// SET FOREIGN_KEY_CHECKS=0;
// ALTER TABLE `sessions` ADD  CONSTRAINT `user_session_fk` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
// SET FOREIGN_KEY_CHECKS=1
