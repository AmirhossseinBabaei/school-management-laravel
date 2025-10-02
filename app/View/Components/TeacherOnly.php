<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class TeacherOnly extends Component
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
     * Check if user is teacher or higher
     */
    public function isTeacher()
    {
        $user = Auth::user();
        
        if (!$user || !$user->role) {
            return false;
        }

        $roleName = $user->role->name;
        
        return in_array($roleName, ['مدیر', 'admin', 'معاون', 'vice', 'معلم', 'teacher']);
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.teacher-only');
    }
}

