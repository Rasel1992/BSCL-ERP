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
            'category' => [
                'see category list',
                'see category details',
                'add category',
                'edit category',
                'delete category'
            ],
            'inventory' => [
                'see inventory list',
                'see inventory details',
                'see inventory QR code list',
                'see inventory summary',
                'add inventory',
                'edit inventory',
                'delete inventory'
            ],
            'stock' => [
                'see stock list',
                'see stock details',
                'see stock summary',
                'add stock',
                'edit stock',
                'delete stock',
                'assign stock',
                'see assigned stock list',
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
