<?php

namespace App\Http\Services;

use App\Exceptions\ServiceException;
use App\Repositories\PetMedicationRepository;

class PetMedicationService
{

    private PetMedicationRepository $petMedicationRepository;

    public function __construct(
        PetMedicationRepository $petMedicationRepository,
    )
    {
        $this->petMedicationRepository = $petMedicationRepository;
    }

    public function index()
    {
        return $this->petMedicationRepository->getAll();
    }

    public function show($id)
    {
        return $this->petMedicationRepository->getById($id);
    }

    public function create(array $parameters)
    {
        $data = [
            'pet_id' => $parameters['pet_id'],
            'medication_name' => $parameters['medication_name'],
            'dosage' => $parameters['dosage'],
            'administration_time' => $parameters['administration_time'],
            'notes' => $parameters['notes'] ?? '',
        ];

        return $this->petMedicationRepository->createData($data);
    }

    public function delete($id)
    {
        $this->petMedicationRepository->deleteById($id);
        return true;
    }

    public function filterByPet($pet_id)
    {
        return $this->petMedicationRepository->filterByPetId($pet_id);
    }
}
