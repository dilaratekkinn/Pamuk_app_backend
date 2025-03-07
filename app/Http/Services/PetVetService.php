<?php

namespace App\Http\Services;

use App\Exceptions\ServiceException;
use App\library\vet_location_bot;
use App\Models\VetCareCenter;
use App\Repositories\PetMedicationRepository;
use App\Repositories\PetVetRepository;

class PetVetService
{

    private PetVetRepository $petVetRepository;

    public function __construct(
        PetVetRepository $petVetRepository,
    )
    {
        $this->petVetRepository = $petVetRepository;
    }

    public function index()
    {
        return $this->petVetRepository->getAll();
    }

    public function show($id)
    {
        return $this->petVetRepository->getById($id);
    }

    public function create(array $parameters)
    {
        $data = [
            'pet_id' => $parameters['pet_id'],
            'visit_date' => $parameters['visit_date'],
            'vet_name' => $parameters['vet_name'],
            'reason' => $parameters['reason'],
            'notes' => $parameters['notes'] ?? '',
        ];

        return $this->petVetRepository->createData($data);
    }

    public function delete($id)
    {
        $this->petVetRepository->deleteById($id);
        return true;
    }

    public function filterByPet($pet_id)
    {
        return $this->petVetRepository->getVetRoutines($pet_id);
    }

    public function nearBy()
    {
        $accessKey = '018077be97671c053d217003f7352aa3';
        $apiUrl = 'https://api.positionstack.com/v1/forward?access_key=' . $accessKey . '&query=';


        $careCenteres = VetCareCenter::where('latitude', '')->where('address', '!=', '')->where('state', '=', 'Kadıköy')->get();
        foreach($careCenteres as $careCentere){
            $query = urlencode($careCentere['address'].' '.$careCentere->state.' '.$careCentere->city);
            $fullApiUrl = $apiUrl . $query;

            $coordinats = json_decode(file_get_contents($fullApiUrl));
            if($coordinats->data)
                foreach ($coordinats->data as $info) {
                    $careCentere->latitude = $info->latitude;
                    $careCentere->longitude = $info->longitude;
                    $careCentere->save();

                    break;
                }
            else{
                $careCentere->latitude = '0';
                $careCentere->longitude = '0';
                $careCentere->save();
            }
        }
        return;
        $filePath = resource_path('/json/cities.json');
        $accessKey = '274600dd027eccb701393a32750d40c5';
        $apiUrl = 'https://api.positionstack.com/v1/forward?access_key=' . $accessKey . '&query=';

        if (!file_exists($filePath)) {
            throw new \Exception('obaa');
        }

        $cities = json_decode(file_get_contents($filePath), true);
        $allVets = [];
        foreach ($cities as $city) {
            $location = new vet_location_bot($city);
            $data = $location->getData();
            foreach ($data as $datum) {
                foreach ($datum['data'] as $item) {
                    if ($item['address_full'] == 'Belirtilmemiş') {
                        continue;
                    }
                    $careCenter = new VetCareCenter();
                    $careCenter->name = $item['name'];
                    $careCenter->address = $item['address'];
                    $careCenter->phone = $item['phone'];
                    $careCenter->state = $datum['state'];
                    $careCenter->city = $datum['city'];
                    $careCenter->latitude = '';
                    $careCenter->longitude = '';
                    $careCenter->save();
                    continue;

                    $query = urlencode($item['address_full']);
                    $fullApiUrl = $apiUrl . $query;

                    $coordinats = json_decode(file_get_contents($fullApiUrl));
                    foreach ($coordinats->data as $info) {
                        $latitude = $info->latitude;
                        $longitude = $info->longitude;
                        $allVets[] = [
                            $item,
                            $latitude,
                            $longitude
                        ];
                        dd($allVets);
                    }

                }
            }
        }

    }

}
