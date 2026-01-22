<?php

namespace App\Models;

class User extends BaseModel
{
    public string $table = "users";

    public function getUser(string $email): array
    {
        $usuario = $this->connection->createQueryBuilder()
            ->select("*")
            ->from($this->table)
            ->where("email = :email")
            ->setParameter("email", $email)
            ->executeQuery()
            ->fetchAssociative();

        if (!$usuario) {
            throw new \Exception("Usuário não encontrado");
        }

        return $usuario;
    }
}