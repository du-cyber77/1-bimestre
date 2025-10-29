<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatCard extends Component
{
    /**
     * Create a new component instance.
     *
     * @param string $value O valor principal (ex: "150")
     * @param string $label O texto descritivo (ex: "Alunos Cadastrados")
     * @param string $icon O ícone do Font Awesome (ex: "fa-user-graduate")
     * @param string $bgColor A classe de cor do Bootstrap (ex: "bg-primary")
     */
    public function __construct(
        public string $value,
        public string $label,
        public string $icon,
        public string $bgColor
    ) {
        // O PHP 8+ automaticamente torna isso disponível como $value, $label, etc.
        // na sua view 'components.stat-card'.
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.stat-card');
    }
}