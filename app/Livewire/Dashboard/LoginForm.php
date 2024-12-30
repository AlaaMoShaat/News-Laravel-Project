<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class LoginForm extends Component
{
    public $password = '';

    public $passwordStrength = '';

    public function updatedPassword()
    {
        $length = strlen($this->password);
        if ($length < 6) {
            $this->passwordStrength = 'Too short';
        } elseif ($length < 8) {
            $this->passwordStrength = 'Weak';
        } elseif (preg_match('/[A-Z]/', $this->password) && preg_match('/[0-9]/', $this->password)) {
            $this->passwordStrength = 'Strong';
        } else {
            $this->passwordStrength = 'Medium';
        }
    }

    public function render()
    {
        return view('livewire.dashboard.login-form');
    }
}
