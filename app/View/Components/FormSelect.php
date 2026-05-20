<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormSelect extends Component
{
    public string $label;
    public string $name;
    public mixed  $value;
    public array  $options;      // ['key' => 'label']
    public string $placeholder;

    public function __construct(
        string $label,
        string $name,
        array  $options     = [],
        mixed  $value       = null,
        string $placeholder = 'Pilih',
    ) {
        $this->label       = $label;
        $this->name        = $name;
        $this->options     = $options;
        $this->value       = $value;
        $this->placeholder = $placeholder;
    }

    public function render(): View|Closure|string
    {
        return view('components.form-select');
    }
}
