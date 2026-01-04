<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ThemeSelect extends Component
{
    public string $model;
    public array $themes;

    public function __construct(string $model)
    {
        $this->model = $model;

        $this->themes = [
            'Love',
            'Breakup',
            'Heartbreak',
            'Friendship',
            'Family',
            'Party',
            'Life Struggles',
            'Mental Health',
            'Success',
            'Motivation',
            'Faith / Spiritual',
            'Loneliness',
            'Hope',
            'Freedom',
            'Revenge',
            'Healing',
        ];
    }

    public function render()
    {
        return view('components.theme-select');
    }
}
