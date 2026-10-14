<?php

use Illuminate\Database\Seeder;
use App\Anggota;
use App\User;
use App\UserAnggota;
use App\Role;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $anggota = new Anggota();
        $anggota->nik = '320209040401001';
        $anggota->nama = 'Agus Permana';
        $anggota->jabatan = 'AP';
        $anggota->homebase = 'Bogor';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();
        $roleUser = Role::where('name', 'member')->first();
        $user->addRole($roleUser);

        $anggota = new Anggota();
        $anggota->nik = '320209050501002';
        $anggota->nama = 'Ahmad Jaelani';
        $anggota->jabatan = 'AJ';
        $anggota->homebase = 'Jakarta';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();

        $user->addRole($roleUser);

        $anggota = new Anggota();
        $anggota->nik = '320209060601003';
        $anggota->nama = 'Miranda';
        $anggota->jabatan = 'M';
        $anggota->homebase = 'Tangerang';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();

        $user->addRole($roleUser);

        $anggota = new Anggota();
        $anggota->nik = '320209070701004';
        $anggota->nama = 'Raka Hadi';
        $anggota->jabatan = 'RH';
        $anggota->homebase = 'Garut';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();

        $user->addRole($roleUser);

        $anggota = new Anggota();
        $anggota->nik = '320209080801005';
        $anggota->nama = 'Hermansyah';
        $anggota->jabatan = 'H';
        $anggota->homebase = 'Bekasi';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();

        $user->addRole($roleUser);

        $anggota = new Anggota();
        $anggota->nik = '320209080801006';
        $anggota->nama = 'Angga Rojak';
        $anggota->jabatan = 'H';
        $anggota->homebase = 'Bekasi';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();

        $user->addRole($roleUser);

        $anggota = new Anggota();
        $anggota->nik = '320209080801007';
        $anggota->nama = 'Kardun';
        $anggota->jabatan = 'H';
        $anggota->homebase = 'Bekasi';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();

        $user->addRole($roleUser);

        $anggota = new Anggota();
        $anggota->nik = '320209080801008';
        $anggota->nama = 'Jaja Miharja';
        $anggota->jabatan = 'H';
        $anggota->homebase = 'Bekasi';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();

        $user->addRole($roleUser);

        $anggota = new Anggota();
        $anggota->nik = '320209080801009';
        $anggota->nama = 'Miharja';
        $anggota->jabatan = 'H';
        $anggota->homebase = 'Bekasi';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user->addRole($roleUser);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();

        $anggota = new Anggota();
        $anggota->nik = '320209080801010';
        $anggota->nama = 'Santika';
        $anggota->jabatan = 'H';
        $anggota->homebase = 'Bekasi';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user->addRole($roleUser);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();
    }
}
