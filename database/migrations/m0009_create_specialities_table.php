<?php

use MasterStudents\Core\Migration;
use Spiral\Database\Injection\Fragment;

class m0009_create_specialities_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("specialities")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->integer("language_id")->nullable(false);
            $schema->string("name")->nullable(false);
            $schema->string("abbreviation")->nullable(false);
            $schema->string("duration")->nullable(false);

            $schema->timestamp("created_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));
            $schema->timestamp("updated_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));

            return [
                "schema" => $schema,
                "foreign_keys" => [
                    [
                        "table" => "specialities",
                        "foreign_key" => "language_id",
                        "references" => "id",
                        "on" => "languages",
                        "delete" => "CASCADE",
                        "update" => "CASCADE"
                    ]
                ]
            ];
        }
    }

    public function down()
    {
        $this->db->table("specialities")->drop();
    }
}