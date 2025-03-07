<?php

namespace App\Http\Services;

use App\Exceptions\ServiceException;
use App\Repositories\PetFoodRepository;

class PetFoodService
{

    private PetFoodRepository $petFoodRepository;

    public function __construct(
        PetFoodRepository $petFoodRepository,
    )
    {
        $this->petFoodRepository = $petFoodRepository;
    }

    public function index()
    {
        return $this->petFoodRepository->getAll();
    }

    public function show($id)
    {
        return $this->petFoodRepository->getById($id);
    }

    public function create(array $parameters)
    {
        $data = [
            'pet_id' => $parameters['pet_id'],
            'food_type' => $parameters['food_type'],
            'food_brand' => $parameters['food_brand'],
            'amount' => $parameters['amount'],
            'meal_repeat' => $parameters['meal_repeat'],
            'time_period' => $parameters['time_period'],
            'notes' => $parameters['notes'] ?? '',
        ];

        return $this->petFoodRepository->createData($data);
    }

    public function delete($id)
    {
        $this->petFoodRepository->deleteById($id);
        return true;
    }

    public function filterByPet($pet_id)
    {
        return $this->petFoodRepository->filterByPetId($pet_id);
    }
}
