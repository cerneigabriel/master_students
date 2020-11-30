<?php

use MasterStudents\Core\Migration;
use Spiral\Database\Injection\Fragment;

class m0000_create_users_table extends Migration
{
    public function up()
    {
        $schema = $this->db->table("users")->getSchema();

        if (!$schema->exists()) {
            $schema->primary("id");

            $schema->string("username", 50)->nullable(false);
            $schema->string("first_name", 50)->nullable(false);
            $schema->string("last_name", 50)->nullable(false);
            $schema->string("email", 100)->nullable(false);
            $schema->string("password")->nullable(false);
            $schema->boolean("email_verified")->nullable(false)->defaultValue(0);
            $schema->date("birth_date");
            $schema->string("phone", 20);
            $schema->string("company", 100);
            $schema->string("speciality", 100);
            $schema->string("gender", 10);
            $schema->text("notes");
            $schema->string("zoom_link");

            $schema->timestamp("created_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));
            $schema->timestamp("updated_at")->nullable(false)->defaultValue(new Fragment("CURRENT_TIMESTAMP"));

            $schema->index(["username", "email"])->unique(true);

            return $schema;
        }
    }

    public function down()
    {
        $this->db->table("users")->drop();
    }
}
