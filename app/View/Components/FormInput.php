<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormInput extends Component
{
    public function __construct(
        public string $label,
        public string $name,
        public string $type        = 'text',
        public string $placeholder = '...',
        public bool   $required    = false,  // ← default false,
        public mixed  $value       = null,   // ← tambah ini tidak wajib diisi
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.form-input');
    }
}
