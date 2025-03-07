<?php

namespace App\Http\Services;

use App\Repositories\PetRoutineRepository;

class PetRoutineService
{

    private PetRoutineRepository $petRoutineRepository;

    public function __construct(
        PetRoutineRepository $petRoutineRepository,
    )
    {
        $this->petRoutineRepository = $petRoutineRepository;
    }

    public function index()
    {
        return $this->petRoutineRepository->getAll();
    }

    public function show($id)
    {
        return $this->petRoutineRepository->getById($id);
    }

    public function create(array $parameters)
    {
        $data = [
            'pet_id' => $parameters['pet_id'],
            'activity_type' => $parameters['activity_type'],
            'activity_time' => $parameters['activity_time'],
            'notes' => $parameters['notes'] ?? '',
        ];

        return $this->petRoutineRepository->createData($data);
    }

    public function delete($id)
    {
        $this->petRoutineRepository->deleteById($id);
        return true;
    }

    public function filterByPet($pet_id)
    {
        return $this->petRoutineRepository->getRoutines($pet_id);
    }
}
