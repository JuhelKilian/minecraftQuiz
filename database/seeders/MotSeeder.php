<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mot;

class MotSeeder extends Seeder
{
    public function run()
    {
        $jsonPath = 'D:\\Users\\kilian\\Downloads\\items(11).json';
        $json = file_get_contents($jsonPath);
        $items = json_decode($json, true);

        $difficultyMap = [
            'simple' => 1,
            'moyen' => 2,
            'difficile' => 3
        ];

        foreach ($items as $item) {
            Mot::create([
                'name_en' => $item['name_en'],
                'name_fr' => $item['name_fr'],
                'name_it' => $item['name_it'],
                'cheminImg' => $item['file'],
                'difficulte' => $difficultyMap[$item['difficulty']] ?? 1,
            ]);
        }
    }
}
