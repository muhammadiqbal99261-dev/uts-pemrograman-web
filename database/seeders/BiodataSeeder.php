<?php

namespace Database\Seeders;

use App\Models\Biodata;
use Illuminate\Database\Seeder;

class BiodataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Biodata::query()
            ->whereIn('nama', ['rizki eka prasodjo', 'andi agus salim'])
            ->delete();

        Biodata::query()->firstOrCreate(
            ['nama' => 'iqbal'],
            [
                'deskripsi' => '24010110190 merupakan master dari uts ini dengan tugas membuat front-end dan mengirimkannya ke grup',
                'foto' => 'images/avatar-1.svg',
            ]
        );

        Biodata::query()->firstOrCreate(
            ['nama' => 'davi'],
            [
                'deskripsi' => 'dengan NIM 24010110214 merupakan pegawai dan mempunyai tugas mengerjakan back-end pada UTS ini',
                'foto' => 'images/avatar-2.svg',
            ]
        );
    }
}
