<?php

use MasterStudents\Core\Migration;
use Spiral\Database\ForeignKeyInterface;
use Spiral\Database\Injection\Fragment;

class m0006_create_role_permission_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("role_permission")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->integer("role_id")->nullable(false);
            $schema->integer("permission_id")->nullable(false);

            $schema->timestamp("created_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));
            $schema->timestamp("updated_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));

            return [
                "schema" => $schema,
                "foreign_keys" => [
                    [
                        "table" => "role_permission",
                        "foreign_key" => "role_id",
                        "references" => "id",
                        "on" => "roles",
                        "delete" => "CASCADE",
                        "update" => "CASCADE"
                    ],
                    [
                        "table" => "role_permission",
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
        $this->db->table("role_permission")->drop();
    }
}