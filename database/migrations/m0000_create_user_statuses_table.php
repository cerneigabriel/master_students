<?php

use MasterStudents\Core\Migration;
use Spiral\Database\Injection\Fragment;

class m0000_create_user_statuses_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("user_statuses")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->string("key")->nullable(false);
            $schema->string("name")->nullable(false);

            $schema->timestamp("created_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));
            $schema->timestamp("updated_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));

            $schema->index(["key"])->unique(true);

            return ["schema" => $schema];
        }
    }

    public function down()
    {
        $this->db->table("user_statuses")->drop();
    }
}
