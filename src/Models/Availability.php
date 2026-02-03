<?php

namespace App\Models;

class Availability extends BaseModel
{
    public string $table = "availabilities";

    public string $start_time;
    public string $end_time;

    /**
     * Verifica se existe conflito de horário
     */
    public function hasConflict(
        int $userId,
        int $weekday,
        string $startTime,
        string $endTime
    ): bool {
        $sql = "
            SELECT COUNT(*) 
            FROM availabilities
            WHERE user_id = :user_id
              AND weekday = :weekday
              AND (
                    start_time < :end_time
                AND end_time   > :start_time
              )
        ";

        $count = $this->connection->fetchOne($sql, [
            'user_id'    => $userId,
            'weekday'    => $weekday,
            'start_time' => $startTime,
            'end_time'   => $endTime,
        ]);

        return $count > 0;
    }

    /**
     * Lista disponibilidades do usuário
     */
    public function allByUser(int $userId): array
    {
        $sql = "
            SELECT *
            FROM availabilities
            WHERE user_id = :user_id
            ORDER BY weekday, start_time
        ";

        return $this->connection->fetchAllAssociative($sql, [
            'user_id' => $userId
        ]);
    }
}
