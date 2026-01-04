<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GenreSelect extends Component
{

    public string $model;
    public array $genres;

    /**
     * Create a new component instance.
     */
    public function __construct(string $model)
    {
        $this->model = $model;
        $this->genres = [
            'Pop','R&B','Rock','Country','Hip-hop','Indie','Electronic','Ethnic',
            'Rap','Classical','Jazz','K-pop','Metal','Oldies','Techno','Folk',
            'Blues','Christian','Gospel','Progressive','Singer-Songwriter','Dance',
            'Funk','Soul','Reggae','World','Other',
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.genre-select');
    }
}
