<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class RoleGate extends Component
{
    public $roles;
    public $permissions;
    public $requireAll;
    public $fallback;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $roles = [],
        $permissions = [],
        $requireAll = false,
        $fallback = false
    ) {
        $this->roles = is_array($roles) ? $roles : [$roles];
        $this->permissions = is_array($permissions) ? $permissions : [$permissions];
        $this->requireAll = $requireAll;
        $this->fallback = $fallback;
    }

    /**
     * Check if user has required roles or permissions
     */
    public function hasAccess()
    {
        $user = Auth::user();
        
        if (!$user) {
            return $this->fallback;
        }

        // Check roles
        if (!empty($this->roles)) {
            $userRole = $user->role;
            if (!$userRole) {
                return $this->fallback;
            }

            if ($this->requireAll) {
                return collect($this->roles)->every(function ($role) use ($userRole) {
                    return $userRole->name === $role;
                });
            } else {
                return collect($this->roles)->contains($userRole->name);
            }
        }

        // Check permissions (if you implement permissions later)
        if (!empty($this->permissions)) {
            // Implement permission checking logic here
            return $this->fallback;
        }

        return true;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.role-gate');
    }
}

