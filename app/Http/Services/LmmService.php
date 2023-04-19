<?php

namespace App\Http\Services;

class LmmService
{
    public function getLmmTempohPembaharuan()
    {
        $result = [];
        for ($i = 1; $i < 6; $i++) {
            $result[] = [
                'display_text' => $i . " tahun",
                'value' => $i
            ];
        }
        return $result;
    }

    public function getJenisLesen()
    {
        $result = array(
            [
                'display_text' => "Lesen Memandu Kompoten (CDL)",
                'value' => "CDL"
            ],
            [
                'display_text' => "Lesen Belajar Memandu (PDL)",
                'value' => "PDL"
            ],
        );

        return $result;
    }
}
