<?php

namespace App\library;
use File;

class vet_location_bot
{

    private $city;
    private $vetListUrl = 'https://veteriner.co/{city}-veteriner-klinikleri.html';

    public function __construct($city)
    {

        if (!$city) {
            throw new \Exception('city is must');

        }


        $this->city = $city;
    }

    public function getData()
    {
        $return = [];

        $city = str_replace(['Ç', 'Ğ', 'İ', 'Ö', 'Ş', 'Ü', 'ç', 'ğ', 'ı', 'ö', 'ş', 'ü', 'Afyonkarahisar'], ['C', 'G', 'I', 'O', 'S', 'U', 'c', 'g', 'i', 'o', 's', 'u', 'Afyon'], $this->city);

        $url = str_replace(['{city}'], [$city], $this->vetListUrl);
        $data = $this->getHtmlFromUrl($url);
        $items = explode('<h2 class="wp-block-heading">', $data);
        for($i=1;$i<count($items);$i++){
            $item = explode(' ', $items[$i], 2);

            $tmp = [
                'city' => ucfirst($this->city),
                'state' => $item[0],
                'data' => []
            ];

            if(!str_contains($item[1], '<tbody')){
                continue;
            }
            try{
                $subData = explode('<tr class="row', explode('<tbody', $item[1])[1]);

            }catch (\Exception $e){
                dd($item[1], $e, $url);
            }
            for($j=1;$j<count($subData);$j++){
                $tm = [
                    'name' => explode('</td>', explode('<td class="column-1">', $subData[$j])[1])[0],
                    'address' => explode('</td>', explode('<td class="column-2">', $subData[$j])[1])[0],
                    'address_full' => '',
                    'phone' => explode('</td>', explode('<td class="column-3">', $subData[$j])[1])[0],
                ];

                $tm['address_full'] = $tm['address'] == 'Belirtilmemiş' ? $tm['address'] : $tm['address'].' '.$item[0].' '.ucfirst($this->city);

                $tmp['data'][] = $tm;
            }

            $return[] = $tmp;

        }


        return $return;
    }

    private function getHtmlFromUrl(string $url)
    {
        $ip = request()->ip();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_TIMEOUT, 6);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("REMOTE_ADDR: " . $ip, "X-Client-IP: " . $ip, "Client-IP: " . $ip, "HTTP_X_FORWARDED_FOR: " . $ip, "X-Forwarded-For: " . $ip));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($info['http_code'] !== 200) {
            throw new \Exception('Http_code Won\'t return 200 '.$url);
        }
        return $data;
    }
}
