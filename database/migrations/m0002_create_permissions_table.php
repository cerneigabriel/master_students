<?php

use MasterStudents\Core\Migration;

class m0002_create_permissions_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("permissions")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->string("key")->nullable(false);
            $schema->string("name")->nullable(false);

            $schema->column("created_at")->timestamp()->nullable(false);
            $schema->column("updated_at")->timestamp()->nullable(false);

            $schema->index(["key"])->unique(true);

            return $schema;
        }
    }

    public function down()
    {
        $this->db->table("permissions")->drop();
    }
}
