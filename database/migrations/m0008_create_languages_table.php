<?php

use MasterStudents\Core\Migration;
use Spiral\Database\Injection\Fragment;

class m0008_create_languages_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("languages")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->string("locale", 10)->nullable(false);
            $schema->string("name")->nullable(false);

            $schema->timestamp("created_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));
            $schema->timestamp("updated_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));
            
            $schema->index(["locale"])->unique(true);

            return ["schema" => $schema];
        }
    }

    public function down()
    {
        $this->db->table("languages")->drop();
    }
}
