<?php

use MasterStudents\Core\Migration;
use Spiral\Database\Injection\Fragment;

class m0010_create_groups_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("groups")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->integer("speciality_id")->nullable(false);
            $schema->string("name", 50)->nullable(false);
            $schema->string("year")->nullable(false);

            $schema->timestamp("created_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));
            $schema->timestamp("updated_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));

            return [
                "schema" => $schema,
                "foreign_keys" => [
                    [
                        "table" => "groups",
                        "foreign_key" => "speciality_id",
                        "references" => "id",
                        "on" => "specialities",
                        "delete" => "CASCADE",
                        "update" => "CASCADE"
                    ]
                ]
            ];
        }
    }

    public function down()
    {
        $this->db->table("groups")->drop();
    }
}