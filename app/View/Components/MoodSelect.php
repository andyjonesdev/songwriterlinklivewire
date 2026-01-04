<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MoodSelect extends Component
{
    public string $model;
    public array $moods;

    public function __construct(string $model)
    {
        $this->model = $model;

        $this->moods = [
            'Happy',
            'Sad',
            'Romantic',
            'Angry',
            'Hopeful',
            'Dark',
            'Chill',
            'Energetic',
            'Aggressive',
            'Melancholic',
            'Uplifting',
            'Moody',
            'Dreamy',
            'Nostalgic',
            'Bittersweet',
        ];
    }

    public function render()
    {
        return view('components.mood-select');
    }
}
