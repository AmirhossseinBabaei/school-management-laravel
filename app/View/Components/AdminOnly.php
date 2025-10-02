<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AdminOnly extends Component
{
    public $fallback;

    /**
     * Create a new component instance.
     */
    public function __construct($fallback = false)
    {
        $this->fallback = $fallback;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        $user = Auth::user();
        
        if (!$user || !$user->role) {
            return false;
        }

        return $user->role->name === 'مدیر' || $user->role->name === 'admin';
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.admin-only');
    }
}

