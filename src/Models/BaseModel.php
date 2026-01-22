<?php

namespace App\Models;

use Dotenv\Dotenv;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class BaseModel
{
    public Connection $connection;
    public string $table = '';

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__, '../../');
        $dotenv->load();

        $this->connection = DriverManager::getConnection([
            'dbname' => $_ENV['MYSQL_DATABASE'],
            'user' => $_ENV['MYSQL_USER'],
            'password' => $_ENV['MYSQL_PASSWORD'],
            'host' => $_ENV['MYSQL_HOST'],
            'driver' => 'pdo_mysql',
            'charset' => 'utf8mb4',
        ]);
    }

    public function getAll(): array
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->table)
            ->executeQuery()
            ->fetchAllAssociative();
    }

    public function store(array $data): void
    {
        $this->connection->insert($this->table, $data);
    }

    public function update(array $data): void
    {
        $this->connection->update($this->table, $data);
    }

    public function delete(array $data): void
    {
        $this->connection->delete($this->table, $data);
    }
}