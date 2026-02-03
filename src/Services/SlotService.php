<?php

namespace App\Services;

use App\Models\Availability;
class SlotService
{
    public static function generate(int $userId, \DateTime $date): array
    {
        $availability = new Availability();

        $availabilities = $availability->connection
            ->createQueryBuilder()
            ->select('start_time', 'end_time', 'slot_duration')
            ->from($availability->table)
            ->where('user_id = :user_id')
            ->andWhere('weekday = :weekday')
            ->setParameter('user_id', $userId)
            ->setParameter('weekday', (int) $date->format('w'))
            ->executeQuery()
            ->fetchAllAssociative();


        if (empty($availabilities)) {
            return [];
        }

        $bookedTimes = [];
        $slots = [];

        foreach ($availabilities as $availability) {
            $start = new \DateTime($date->format('Y-m-d') . ' ' . $availability['start_time']);
            $end   = new \DateTime($date->format('Y-m-d') . ' ' . $availability['end_time']);

            while (true) {
                $slotEnd = (clone $start)->modify('+' . $availability['slot_duration'] . ' minutes');

                if ($slotEnd > $end) {
                    break;
                }

                $startTime = $start->format('H:i');

                if (! in_array($startTime, $bookedTimes, true)) {
                    $slots[] = [
                        'start' => $startTime,
                        'end'   => $slotEnd->format('H:i'),
                    ];
                }

                $start = $slotEnd;
            }
        }

        return $slots;
    }
}
