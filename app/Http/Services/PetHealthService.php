<?php

namespace App\Http\Services;

use App\Repositories\PetHealthRepository;

class PetHealthService
{

    private PetHealthRepository $petHealthRepository;

    public function __construct(
        PetHealthRepository $petHealthRepository,
    )
    {
        $this->petHealthRepository = $petHealthRepository;
    }

    public function index()
    {
        return $this->petHealthRepository->getAll();
    }

    public function show($id)
    {
        return $this->petHealthRepository->getById($id);
    }

    public function create(array $parameters)
    {
        $data = [
            'pet_id' => $parameters['pet_id'],
            'health_condition' => $parameters['health_condition'],
            'diagnosis_date' => $parameters['diagnosis_date'],
            'treatment' => $parameters['treatment'],
            'notes' => $parameters['notes'],
        ];

        return $this->petHealthRepository->createData($data);
    }

    public function updateData($id, array $parameters)
    {
        $data = [
            'health_condition' => $parameters['health_condition'],
            'diagnosis_date' => $parameters['diagnosis_date'],
            'treatment' => $parameters['treatment'],
            'notes' => $parameters['notes'] ?? '',
        ];
        return $this->petHealthRepository->updateData($id, $data);
    }

    public function delete($id)
    {
        $this->petHealthRepository->deleteById($id);
        return true;
    }

    public function filterByPet($pet_id)
    {
        return $this->petHealthRepository->filterByPetId($pet_id);
    }
}
