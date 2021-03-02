<?php

use MasterStudents\Core\Migration;
use Spiral\Database\ForeignKeyInterface;
use Spiral\Database\Injection\Fragment;

class m0005_create_user_role_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("user_role")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->integer("user_id")->nullable(false);
            $schema->integer("role_id")->nullable(false);

            $schema->timestamp("created_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));
            $schema->timestamp("updated_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));

            return [
                "schema" => $schema,
                "foreign_keys" => [
                    [
                        "table" => "user_role",
                        "foreign_key" => "user_id",
                        "references" => "id",
                        "on" => "users",
                        "delete" => "CASCADE",
                        "update" => "CASCADE"
                    ],
                    [
                        "table" => "user_role",
                        "foreign_key" => "role_id",
                        "references" => "id",
                        "on" => "roles",
                        "delete" => "CASCADE",
                        "update" => "CASCADE"
                    ]
                ]
            ];
        }
    }

    public function down()
    {
        $this->db->table("user_role")->drop();
    }
}