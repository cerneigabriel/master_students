<?php

use MasterStudents\Core\Migration;

class m0001_create_roles_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("roles")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->string("key", 50)->nullable(false);
            $schema->string("name", 100)->nullable(false);

            $schema->column("created_at")->timestamp()->nullable(false);
            $schema->column("updated_at")->timestamp()->nullable(false);

            $schema->index(["key"])->unique(true);

            return $schema;
        }
    }

    public function down()
    {
        $this->db->table("roles")->drop();
    }
}
