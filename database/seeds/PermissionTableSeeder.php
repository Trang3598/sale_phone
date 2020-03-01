<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'sale_phone-list',
            'sale_phone-create',
            'sale_phone-edit',
            'sale_phone-delete',
            'order-list',
            'order-create',
            'order-edit',
            'order-delete',
            'order_detail-list',
            'order_detail-create',
            'order_detail-edit',
            'order_detail-delete',
            'comment-list',
            'comment-create',
            'comment-edit',
            'comment-delete',
            'image-list',
            'image-create',
            'image-edit',
            'image-delete',
            'deliverer-list',
            'deliverer-create',
            'deliverer-edit',
            'deliverer-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'color-list',
            'color-create',
            'color-edit',
            'color-delete',
            'status-list',
            'status-create',
            'status-edit',
            'status-delete',

        ];


        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
