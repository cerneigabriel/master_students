<?php

use MasterStudents\Core\Migration;
use Spiral\Database\Injection\Fragment;

class m0002_create_permissions_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("permissions")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->string("key")->nullable(false);
            $schema->string("name")->nullable(false);

            $schema->timestamp("created_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));
            $schema->timestamp("updated_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));

            $schema->index(["key"])->unique(true);

            return $schema;
        }
    }

    public function down()
    {
        $this->db->table("permissions")->drop();
    }
}
