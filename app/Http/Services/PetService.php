<?php

namespace App\Http\Services;

use App\Models\UserPet;
use App\Repositories\PetRepository;
use Illuminate\Support\Str;

class PetService
{

    private PetRepository $petRepository;

    public function __construct(
        PetRepository $petRepository,
    )
    {
        $this->petRepository = $petRepository;

    }
    public function index()
    {
        return $this->petRepository->getAll();
    }

    public function show($id)
    {
        return $this->petRepository->getById($id);
    }

    public function create(array $parameters)
    {
        if (!empty($parameters['pet_image'])) {
            $pet_image = Str::slug($parameters['name']) . '_' . time() . '.' . $parameters['pet_image']->extension();
            $parameters['pet_image']->storeAs('uploads', $pet_image, 'public');
            $pet_image = '/uploads/'.$pet_image;
        }else{
            $pet_image=null;
        }

        $data = [
            'name' => $parameters['name'],
            'species' => $parameters['species'],
            'age' => $parameters['age'],
            'pet_image' => $pet_image
        ];

        $final = $this->petRepository->createData($data);

        $userPet = new UserPet();
        $userPet->pet_id = $final->id;
        $userPet->user_id = auth()->user()->id;
        $userPet->save();

        return $final;
    }

    public function delete($id)
    {
        $this->petRepository->deleteById($id);
        return true;
    }
}
