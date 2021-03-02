<?php

use MasterStudents\Core\Migration;
use Spiral\Database\Injection\Fragment;

class m0007_create_user_permission_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("user_permission")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->integer("user_id")->nullable(false);
            $schema->integer("permission_id")->nullable(false);

            $schema->timestamp("created_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));
            $schema->timestamp("updated_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));

            return [
                "schema" => $schema,
                "foreign_keys" => [
                    [
                        "table" => "user_permission",
                        "foreign_key" => "user_id",
                        "references" => "id",
                        "on" => "users",
                        "delete" => "CASCADE",
                        "update" => "CASCADE"
                    ],
                    [
                        "table" => "user_permission",
                        "foreign_key" => "permission_id",
                        "references" => "id",
                        "on" => "permissions",
                        "delete" => "CASCADE",
                        "update" => "CASCADE"
                    ]
                ]
            ];
        }
    }

    public function down()
    {
        $this->db->table("user_permission")->drop();
    }
}