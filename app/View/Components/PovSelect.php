<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PovSelect extends Component
{
    public string $model;
    public array $povs;

    public function __construct(string $model)
    {
        $this->model = $model;

        $this->povs = [
            'First Person (I / Me)',
            'Second Person (You)',
            'Third Person (They)',
        ];
    }

    public function render()
    {
        return view('components.pov-select');
    }
}
