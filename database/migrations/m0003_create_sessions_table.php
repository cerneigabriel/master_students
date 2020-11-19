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
            $schema->boolean("active")->nullable(false)->defaultValue(0);
            $schema->string("session_id")->nullable(false);
            $schema->json("session_data")->nullable(false);
            $schema->string("ip")->nullable(false);

            $schema->column("created_at")->timestamp()->nullable(false);
            $schema->column("updated_at")->timestamp()->nullable(false);

            $schema->index(["session_id"])->unique(true);

            return $schema;
        }
    }

    public function down()
    {
        $this->db->table("sessions")->drop();
    }
}
