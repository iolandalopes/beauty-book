<?php

namespace App\Support;

use App\Support\Authentication;

class Authorization
{
    public static function isOwner(int $entityId, string $entityType): void
    {
        $entity = $entityType::find($entityId);

        if (!$entity) {
            http_response_code(404);
            exit('Entidade não encontrada');
        }

        if ($entity['user_id'] !== Authentication::id()) {
            http_response_code(403);
            exit('Acesso negado');
        }
    }
}
