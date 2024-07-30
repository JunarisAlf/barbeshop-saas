<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Resource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        

        $userResource = Resource::create(['name' => 'User', 'display' => 'Pengguna']);
        $userResource->permissions()->saveMany([
            new Permission(['name' => 'viewAnyUser', 'display' => 'Lihat List Pengguna']),
            new Permission(['name' => 'viewUser', 'display' => 'Lihat Detail Pengguna']),
            new Permission(['name' => 'createUser', 'display' => 'Menambahkan Pengguna Baru']),
            new Permission(['name' => 'updateUser', 'display' => 'Mengubah Data Pengguna']),
            new Permission(['name' => 'deleteUser', 'display' => 'Menghapus Data Pengguna']),
            new Permission(['name' => 'restoreUser', 'display' => 'Mengembalikan Data Pengguna Terhapus']),
            new Permission(['name' => 'forceDeleteUser', 'display' => 'Menghapus Permanen Data Pengguna']),
        ]);

        $paymentResource = Resource::create(['name' => 'Payment', 'display' => 'Pwmbayaran']);
        $paymentResource->permissions()->saveMany([
            new Permission(['name' => 'viewAnyPayment', 'display' => 'Lihat List Pembayaran']),
            new Permission(['name' => 'viewPayment', 'display' => 'Lihat Detail Pembayaran']),
            new Permission(['name' => 'createPayment', 'display' => 'Menambahkan Pembayaran Baru']),
            new Permission(['name' => 'updatePayment', 'display' => 'Mengubah Data Pembayaran']),
            new Permission(['name' => 'deletePayment', 'display' => 'Menghapus Data Pembayaran']),
            new Permission(['name' => 'restorePayment', 'display' => 'Mengembalikan Data Pembayaran Terhapus']),
            new Permission(['name' => 'forceDeletePayment', 'display' => 'Menghapus Permanen Data Pembayaran']),
        ]);

        $ownerRole      = Role::create(['name' => 'Owner', 'barbershop_id' => 1]);
        $ownerRole->users()->attach(1); // user with id 1 made at Barbershop Seeder
        $ownerRole->permissions()->attach($userResource->permissions()->pluck('id'));
        $ownerRole->permissions()->attach($paymentResource->permissions()->pluck('id'));

    }
}
