<?php

use MasterStudents\Core\Migration;
use Spiral\Database\ForeignKeyInterface;
use Spiral\Database\Injection\Fragment;

class m0004_create_sessions_table extends Migration
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

            $schema->timestamp("created_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));
            $schema->timestamp("updated_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));

            $schema->index(["token"])->unique(true);

            return [
                "schema" => $schema,
                "foreign_keys" => [
                    [
                        "table" => "sessions",
                        "foreign_key" => "user_id",
                        "references" => "id",
                        "on" => "users",
                        "delete" => "CASCADE",
                        "update" => "CASCADE"
                    ]
                ]
            ];
        }
    }

    public function down()
    {
        $this->db->table("sessions")->drop();
    }
}