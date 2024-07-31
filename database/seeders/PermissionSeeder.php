<?php

namespace Database\Seeders;

use App\Models\Barbershop;
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
            new Permission(['name' => 'changePassword', 'display' => 'Mengubah Password Semua User']),
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

        $RoleResource = Resource::create(['name' => 'Role', 'display' => 'Role']);
        $RoleResource->permissions()->saveMany([
            new Permission(['name' => 'viewAnyRole', 'display' => 'Lihat List Role']),
            new Permission(['name' => 'viewRole', 'display' => 'Lihat Detail Role']),
            new Permission(['name' => 'createRole', 'display' => 'Menambahkan Role Baru']),
            new Permission(['name' => 'updateRole', 'display' => 'Mengubah Data Role']),
            new Permission(['name' => 'deleteRole', 'display' => 'Menghapus Data Role']),
            new Permission(['name' => 'restoreRole', 'display' => 'Mengembalikan Data Role Terhapus']),
            new Permission(['name' => 'forceDeleteRole', 'display' => 'Menghapus Permanen Data Role']),
        ]);

    }
}
