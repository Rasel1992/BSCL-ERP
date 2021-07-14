<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrPermissions = [
            'department' => [
                'see department list',
                'see department details',
                'add department',
                'edit department',
                'delete department'
            ],
            'user' => [
                'see user list',
                'see user details',
                'change password',
                'add user',
                'edit user',
                'delete user'
            ],
            'shift' => [
                'see shift list',
                'see shift details',
                'add shift',
                'edit shift',
                'delete shift'
            ],
            'set roster' => [
                'see set roster list',
                'see set roster details',
                'add set roster',
                'edit set roster',
                'delete set roster'
            ],
            'inventory category' => [
                'see inventory category list',
                'see inventory category details',
                'add inventory category',
                'edit inventory category',
                'delete inventory category'
            ],
            'stock category' => [
                'see stock category list',
                'see stock category details',
                'add stock category',
                'edit stock category',
                'delete stock category'
            ],
            'inventory' => [
                'see inventory list',
                'see inventory details',
                'see inventory QR code list',
                'see inventory all summary',
                'see inventory summary',
                'add inventory',
                'edit inventory',
                'delete inventory'
            ],
            'stock' => [
                'see stock list',
                'see stock details',
                'see stock all summary',
                'see stock summary',
                'add stock',
                'edit stock',
                'delete stock',
                'assign stock',
                'see assigned stock list',
                'see updated stock list',
            ],
            'role' => [
                'see role list',
                'see role details',
                'add role',
                'edit role',
                'delete role'
            ],
            'setting' => [
                'activity',
            ],

        ];

        foreach($arrPermissions as $key => $apArr) {
            foreach($apArr as $ap) {
                Permission::create(['module' => $key, 'name' => $ap, 'guard_name' => 'web']);
            }
        }
    }
}
