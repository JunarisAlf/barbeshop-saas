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

        $paymentResource = Resource::create(['name' => 'Payment', 'display' => 'Pembayaran']);
        $paymentResource->permissions()->saveMany([
            new Permission(['name' => 'viewAnyPayment', 'display' => 'Lihat List Pembayaran']),
            new Permission(['name' => 'viewPayment', 'display' => 'Lihat Detail Pembayaran']),
            new Permission(['name' => 'createPayment', 'display' => 'Menambahkan Pembayaran Baru']),
            new Permission(['name' => 'updatePayment', 'display' => 'Mengubah Data Pembayaran']),
            new Permission(['name' => 'deletePayment', 'display' => 'Menghapus Data Pembayaran']),
            new Permission(['name' => 'restorePayment', 'display' => 'Mengembalikan Data Pembayaran Terhapus']),
            new Permission(['name' => 'forceDeletePayment', 'display' => 'Menghapus Permanen Data Pembayaran']),
        ]);

        $roleResource = Resource::create(['name' => 'Role', 'display' => 'Role']);
        $roleResource->permissions()->saveMany([
            new Permission(['name' => 'viewAnyRole', 'display' => 'Lihat List Role']),
            new Permission(['name' => 'viewRole', 'display' => 'Lihat Detail Role']),
            new Permission(['name' => 'createRole', 'display' => 'Menambahkan Role Baru']),
            new Permission(['name' => 'updateRole', 'display' => 'Mengubah Data Role']),
            new Permission(['name' => 'deleteRole', 'display' => 'Menghapus Data Role']),
            new Permission(['name' => 'restoreRole', 'display' => 'Mengembalikan Data Role Terhapus']),
            new Permission(['name' => 'forceDeleteRole', 'display' => 'Menghapus Permanen Data Role']),
        ]);

        $scheduleResource = Resource::create(['name' => 'Schedule', 'display' => 'Jadwal']);
        $scheduleResource->permissions()->saveMany([
            new Permission(['name' => 'viewAnySchedule', 'display' => 'Lihat List Jadwal']),
            new Permission(['name' => 'viewSchedule', 'display' => 'Lihat Detail Jadwal']),
            new Permission(['name' => 'createSchedule', 'display' => 'Menambahkan Jadwal Baru']),
            new Permission(['name' => 'updateSchedule', 'display' => 'Mengubah Data Jadwal']),
            new Permission(['name' => 'deleteSchedule', 'display' => 'Menghapus Data Jadwal']),
            new Permission(['name' => 'restoreSchedule', 'display' => 'Mengembalikan Data Jadwal Terhapus']),
            new Permission(['name' => 'forceDeleteSchedule', 'display' => 'Menghapus Permanen Data Jadwal']),
        ]);

        $seatResource = Resource::create(['name' => 'Seat', 'display' => 'Kursi']);
        $seatResource->permissions()->saveMany([
            new Permission(['name' => 'viewAnySeat', 'display' => 'Lihat List Kursi']),
            new Permission(['name' => 'viewSeat', 'display' => 'Lihat Detail Kursi']),
            new Permission(['name' => 'createSeat', 'display' => 'Menambahkan Kursi Baru']),
            new Permission(['name' => 'updateSeat', 'display' => 'Mengubah Data Kursi']),
            new Permission(['name' => 'deleteSeat', 'display' => 'Menghapus Data Kursi']),
            new Permission(['name' => 'restoreSeat', 'display' => 'Mengembalikan Data Kursi Terhapus']),
            new Permission(['name' => 'forceDeleteSeat', 'display' => 'Menghapus Permanen Data Kursi']),
        ]);

        $employeeResource = Resource::create(['name' => 'Employee', 'display' => 'Pegawai']);
        $employeeResource->permissions()->saveMany([
            new Permission(['name' => 'viewAnyEmployee', 'display' => 'Lihat List Pegawai']),
            new Permission(['name' => 'viewEmployee', 'display' => 'Lihat Detail Pegawai']),
            new Permission(['name' => 'createEmployee', 'display' => 'Menambahkan Pegawai Baru']),
            new Permission(['name' => 'updateEmployee', 'display' => 'Mengubah Data Pegawai']),
            new Permission(['name' => 'deleteEmployee', 'display' => 'Menghapus Data Pegawai']),
            new Permission(['name' => 'restoreEmployee', 'display' => 'Mengembalikan Data Pegawai Terhapus']),
            new Permission(['name' => 'forceDeleteEmployee', 'display' => 'Menghapus Permanen Data Pegawai']),
        ]);

        $memberResource = Resource::create(['name' => 'Member', 'display' => 'Pelanggan']);
        $memberResource->permissions()->saveMany([
            new Permission(['name' => 'viewAnyMember', 'display' => 'Lihat List Pelanggan']),
            new Permission(['name' => 'viewMember', 'display' => 'Lihat Detail Pelanggan']),
            new Permission(['name' => 'createMember', 'display' => 'Menambahkan Pelanggan Baru']),
            new Permission(['name' => 'updateMember', 'display' => 'Mengubah Data Pelanggan']),
            new Permission(['name' => 'deleteMember', 'display' => 'Menghapus Data Pelanggan']),
            new Permission(['name' => 'restoreMember', 'display' => 'Mengembalikan Data Pelanggan Terhapus']),
            new Permission(['name' => 'forceDeleteMember', 'display' => 'Menghapus Permanen Data Pelanggan']),
        ]);

        $orderResource = Resource::create(['name' => 'Order', 'display' => 'Order']);
        $orderResource->permissions()->saveMany([
            new Permission(['name' => 'viewAnyOrder', 'display' => 'Lihat List Order']),
            new Permission(['name' => 'viewOrder', 'display' => 'Lihat Detail Order']),
            new Permission(['name' => 'createOrder', 'display' => 'Menambahkan Order Baru']),
            new Permission(['name' => 'updateOrder', 'display' => 'Mengubah Data Order']),
            new Permission(['name' => 'deleteOrder', 'display' => 'Menghapus Data Order']),
            new Permission(['name' => 'restoreOrder', 'display' => 'Mengembalikan Data Order Terhapus']),
            new Permission(['name' => 'forceDeleteOrder', 'display' => 'Menghapus Permanen Data Order']),
        ]);

        $serviceResource = Resource::create(['name' => 'Service', 'display' => 'Layanan']);
        $serviceResource->permissions()->saveMany([
            new Permission(['name' => 'viewAnyService', 'display' => 'Lihat List Layanan']),
            new Permission(['name' => 'viewService', 'display' => 'Lihat Detail Layanan']),
            new Permission(['name' => 'createService', 'display' => 'Menambahkan Layanan Baru']),
            new Permission(['name' => 'updateService', 'display' => 'Mengubah Data Layanan']),
            new Permission(['name' => 'deleteService', 'display' => 'Menghapus Data Layanan']),
            new Permission(['name' => 'restoreService', 'display' => 'Mengembalikan Data Layanan Terhapus']),
            new Permission(['name' => 'forceDeleteService', 'display' => 'Menghapus Permanen Data Layanan']),
        ]);
    }
}
