<?php

namespace App\Database\Seeds;

use App\Models\Groups;
use CodeIgniter\Database\Seeder;

class Group extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'mahasiswa',
            ],
            [
                'name' => 'dosen',
            ],
            [
                'name' => 'admin',
            ],
        ];

        $model = new Groups();
        $model->insertBatch($data);
    }
}
