<?php

namespace Pichau\DigitalCep;

use Pichau\DigitalCep\ws\ViaCep;

class Search
{
    private $url = "https://viacep.com.br/ws/";

    public function getAdressFromZipcode(string $zipCode): array
    {
        $zipCode = preg_replace('/[^0-9]/im', '', $zipCode);

        return $this->getFromServer($zipCode);
    }

    private function getFromServer(string $zipCode): array
    {
        $get = new ViaCep();

        return $get->get($zipCode);
    }

    private function processData($data)
    {
        foreach ($data as $k => $v) {
            $data[$k] = trim($v);
        }

        return $data;
    }
}
