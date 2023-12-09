<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void   
    {
         // define gate for User update credentials  
         Gate::define('Manage-User-EditCredentials', function ($user) {
            $userRole  = $user->userHasRole->role_has_permissions;
            foreach ($userRole as $permission) {
                if ($permission->permissions->name == 'Manage-User-EditCredentials') {
                    return true;
                }
            }
        });

        // define gate for User add, view all
        Gate::define('Manage-User-Add-ViewAll', function ($user) {  
            $userRole  = $user->userHasRole->role_has_permissions;
            foreach ($userRole as $permission) {
                if ($permission->permissions->name == 'Manage-User-Add-ViewAll') {
                    return true;
                }
            }
        });

        // define gate for single User view and update normal details 
        Gate::define('Manage-User', function ($user) {
            $userRole  = $user->userHasRole->role_has_permissions;
            foreach ($userRole as $permission) {
                if ($permission->permissions->name == 'Manage-User') {
                    return true;
                }
            }
        });

        // define gate for Category update and delete  
        Gate::define('Manage-Category-Edit-Delete', function ($user) {
            $userRole  = $user->userHasRole->role_has_permissions;
            foreach ($userRole as $permission) {
                if ($permission->permissions->name == 'Manage-Category-Edit-Delete') {
                    return true;
                }
            }
        });

        // define gate for add Category  
        Gate::define('Manage-Category-Add', function ($user) {
            $userRole  = $user->userHasRole->role_has_permissions;
            foreach ($userRole as $permission) {
                if ($permission->permissions->name == 'Manage-Category-Add') {
                    return true;
                }
            }
        });

        // define gate for Category view
        Gate::define('Manage-Category', function ($user) {
            $userRole  = $user->userHasRole->role_has_permissions;
            foreach ($userRole as $permission) {
                if ($permission->permissions->name == 'Manage-Category') {
                    return true;
                }
            }
        });

        // define gate for update product magnitude attribute values and delete 
        Gate::define('Manage-Product-EditCredentials-Delete', function ($user) {
            $userRole  = $user->userHasRole->role_has_permissions;
            foreach ($userRole as $permission) {
                if ($permission->permissions->name == 'Manage-Product-EditCredentials-Delete') {
                    return true;
                }
            }
        });

        // define gate for update product attribute names and add 
        Gate::define('Manage-Product-Add-Edit', function ($user) {
            $userRole  = $user->userHasRole->role_has_permissions;
            foreach ($userRole as $permission) {
                if ($permission->permissions->name == 'Manage-Product-Add-Edit') {
                    return true;
                }
            }
        });

        // define gate for Product view 
        Gate::define('Manage-Product', function ($user) {
            $userRole  = $user->userHasRole->role_has_permissions;
            foreach ($userRole as $permission) {
                if ($permission->permissions->name == 'Manage-Product') {
                    return true;
                }
            }
        });

        // define gate for all Review permission 
        Gate::define('Manage-Review', function ($user) {
            $userRole  = $user->userHasRole->role_has_permissions;
            foreach ($userRole as $permission) {
                if ($permission->permissions->name == 'Manage-Review') {
                    return true;
                }
            }
        });

        // define gate for all Wishlist permission  
        Gate::define('Manage-Wishlist', function ($user) {
            $userRole  = $user->userHasRole->role_has_permissions;
            foreach ($userRole as $permission) {
                if ($permission->permissions->name == 'Manage-Wishlist') {
                    return true;
                }
            }
        });

        // define gate for User Cart  
        Gate::define('Manage-Cart', function ($user) {
            $userRole  = $user->userHasRole->role_has_permissions;
            foreach ($userRole as $permission) {
                if ($permission->permissions->name == 'Manage-Cart') {
                    return true;
                }
            }
        });

        // define gate for Order  
        Gate::define('Manage-Order', function ($user) {
            $userRole  = $user->userHasRole->role_has_permissions;
            foreach ($userRole as $permission) {
                if ($permission->permissions->name == 'Manage-Order') {
                    return true;
                }
            }
        });

        // define gate for Transaction
        Gate::define('Manage-Transaction', function ($user) {
            $userRole  = $user->userHasRole->role_has_permissions;
            foreach ($userRole as $permission) {
                if ($permission->permissions->name == 'Manage-Transaction') {
                    return true;
                }
            }
        });
    }
}
