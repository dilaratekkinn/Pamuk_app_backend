<?php

namespace App\Http\Services;

use App\Repositories\ReminderRepository;
use function PHPUnit\Framework\isEmpty;

class ReminderService
{

    private ReminderRepository $reminderRepository;

    public function __construct(
        ReminderRepository $reminderRepository,
    )
    {
        $this->reminderRepository = $reminderRepository;
    }

    public function filterByPet($pet_id)
    {
        $reminders= $this->reminderRepository->reminderPet($pet_id);
        if ($reminders == null) {
            throw new \Exception('No Pet Id OR REMINDER');

        }
        return $reminders;
    }

    public function delete($id)
    {
        $this->reminderRepository->deleteById($id);
        return true;
    }

}
