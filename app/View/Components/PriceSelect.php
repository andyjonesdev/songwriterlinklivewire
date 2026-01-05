<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PriceSelect extends Component
{
    public string $model;
    public array $prices;

    public function __construct(string $model)
    {
        $this->model = $model;

        // Prices: 10, 20, ..., 100
        $this->prices = range(20, 60, 20);
    }

    public function render()
    {
        return view('components.price-select');
    }
}
