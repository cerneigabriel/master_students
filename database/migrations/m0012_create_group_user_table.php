<?php

use MasterStudents\Core\Migration;
use Spiral\Database\Injection\Fragment;

class m0012_create_group_user_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("group_user")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->integer("group_id")->nullable(false);
            $schema->integer("user_id")->nullable(false);
            $schema->integer("role_id")->nullable(false);
            $schema->integer("group_user_status_id")->nullable(false);
            $schema->string("token")->nullable(true);

            $schema->timestamp("created_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));
            $schema->timestamp("updated_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));
            
            $schema->index(["token"])->unique(true);

            return [
                "schema" => $schema,
                "foreign_keys" => [
                    [
                        "table" => "group_user",
                        "foreign_key" => "group_id",
                        "references" => "id",
                        "on" => "groups",
                        "delete" => "CASCADE",
                        "update" => "CASCADE"
                    ],
                    [
                        "table" => "group_user",
                        "foreign_key" => "user_id",
                        "references" => "id",
                        "on" => "users",
                        "delete" => "CASCADE",
                        "update" => "CASCADE"
                    ],
                    [
                        "table" => "group_user",
                        "foreign_key" => "role_id",
                        "references" => "id",
                        "on" => "roles",
                        "delete" => "CASCADE",
                        "update" => "CASCADE"
                    ],
                    [
                        "table" => "group_user",
                        "foreign_key" => "group_user_status_id",
                        "references" => "id",
                        "on" => "group_user_statuses",
                        "delete" => "CASCADE",
                        "update" => "CASCADE"
                    ]
                ]
            ];
        }
    }

    public function down()
    {
        $this->db->table("group_user")->drop();
    }
}