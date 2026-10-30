<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Every admin permission, grouped by resource.
     *
     * @var array<string, list<string>>
     */
    public const PERMISSIONS = [
        'blog categories' => ['view blog categories', 'create blog categories', 'edit blog categories', 'delete blog categories'],
        'blog tags' => ['view blog tags', 'create blog tags', 'edit blog tags', 'delete blog tags'],
        'blogs' => ['view blogs', 'create blogs', 'edit blogs', 'delete blogs', 'publish blogs'],
        'features' => ['view features', 'create features', 'edit features', 'delete features'],
        'industries' => ['view industries', 'create industries', 'edit industries', 'delete industries'],
        'partner categories' => ['view partner categories', 'create partner categories', 'edit partner categories', 'delete partner categories'],
        'partners' => ['view partners', 'create partners', 'edit partners', 'delete partners'],
        'testimonials' => ['view testimonials', 'create testimonials', 'edit testimonials', 'delete testimonials'],
        'enquiries' => ['view enquiries', 'edit enquiries', 'delete enquiries'],
        'seo' => ['view seo', 'edit seo'],
    ];

    /**
     * Create the admin permissions, the super-admin / editor / author roles and the first admin user.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $all = collect(self::PERMISSIONS)->flatten();
        $all->each(fn (string $name) => Permission::findOrCreate($name, 'web'));
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // super-admin gets every ability through Gate::before in AppServiceProvider
        Role::findOrCreate('super-admin', 'web');

        Role::findOrCreate('editor', 'web')->syncPermissions($all);

        Role::findOrCreate('author', 'web')->syncPermissions([
            'view blog categories', 'view blog tags', 'view blogs', 'create blogs', 'edit blogs',
        ]);

        $admin = User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@zeebroo.com')],
            ['name' => 'Zeebroo Admin', 'password' => env('ADMIN_PASSWORD', 'password')],
        );
        $admin->assignRole('super-admin');
    }
}
