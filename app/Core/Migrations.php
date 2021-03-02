<?php

namespace MasterStudents\Core;

use MasterStudents\Core\Traits\DatabaseManagerTrait;
use Collections\Map;
use Spiral\Database\Schema\Reflector;

class Migrations
{
    use DatabaseManagerTrait;

    protected $table = "migrations";
    protected $repository;

    protected $foreign_keys;

    public function __construct()
    {
        $this->selectDatabase();

        if (!$this->db->hasTable($this->table)) {
            $this->setRepository($this->db->table($this->table));
            $this->generateTable();
        }

        $this->setRepository($this->db->table($this->table));
    }

    public function migrate()
    {
        $toApplyMigrations = $this->getMigrationsToMigrate();
        $migrations = [];
        $reflector = new Reflector();

        $this->foreign_keys = [];

        foreach ($toApplyMigrations as $migration) {
            require_once MIGRATIONS_PATH . $migration . ".php";

            $migrations[] = $class = new $migration();

            $this->log("Migrate: $migration");
            $class = $class->selectDatabase()->up();

            $reflector->addTable($class["schema"]);
            $this->foreign_keys = array_merge($this->foreign_keys, $class["foreign_keys"] ?? []);
        }

        $reflector->run();

        foreach ($migrations as $class) {
            $class->register();
            $this->log("Migrated: $migration");
        }
        
        $this->attachForeignKeys();
        $this->log("Foreign Keys was created");


        $this->log((count($toApplyMigrations) === 0 ? "Nothing to migrate" : "All migrations are applied"));
    }

    protected function setRepository($repository)
    {
        $this->repository = $repository;
    }

    protected function generateTable()
    {
        $schema = $this->repository->getSchema();

        $schema->primary("id")->bigInteger();
        $schema->column("migration")->string()->nullable(false);
        $schema->column("created_at")->timestamp()->nullable(false);

        $schema->index(["migration"])->unique(true);

        $schema->save();
    }

    protected function getMigrations(): array
    {
        $migrations = map(scandir(MIGRATIONS_PATH));

        $migrations = $migrations->filter(fn ($value) => ($value !== "." && $value !== ".."))->map(fn ($value) => (pathinfo($value, PATHINFO_FILENAME)));

        return array_unique($migrations->toArray());
    }

    protected function getMigratedMigrations(): array
    {
        $migrations = map($this->repository->select()->columns("migration")->fetchAll());

        $migrations = $migrations->map(fn ($value) => ($value["migration"]));

        return array_unique($migrations->toArray());
    }

    protected function getMigrationsToMigrate(): array
    {
        $migrations = $this->getMigrations();
        $migrated = $this->getMigratedMigrations();

        $toApplyMigrations = array_diff($migrations, $migrated);

        return $toApplyMigrations;
    }

    protected function attachForeignKeys() :void {
        $query = "SET FOREIGN_KEY_CHECKS=0;";

        foreach($this->foreign_keys as $item) {
            $query .= "ALTER TABLE `{$item["table"]}` ADD CONSTRAINT `fk_{$item["table"]}_{$item["foreign_key"]}_" . time() . "` FOREIGN KEY (`{$item["foreign_key"]}`) REFERENCES `{$item["on"]}` (`{$item["references"]}`) ON DELETE {$item["delete"]} ON UPDATE {$item["update"]};";
        };
        
        $query .= "SET FOREIGN_KEY_CHECKS=1;";

        $this->db->execute($query);
    }

    protected function log(string $message): void
    {
        echo "[" . date("Y-m-d H:i:s") . "] - $message" . PHP_EOL;
    }
}
