<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EspecialidadPaginaPrincipal extends Component
{
    public $nombre;
    public $imagen;

    public function __construct($nombre,$imagen)
    {
        $this->nombre=$nombre;
        $this->imagen=$imagen;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.especialidad-pagina-principal');
    }
}
