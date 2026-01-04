<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LanguageSelect extends Component
{
    public string $model;
    public array $languages;

    public function __construct(string $model)
    {
        $this->model = $model;

        $this->languages = [
            'English',
            'Spanish',
            'French',
            'German',
            'Italian',
            'Portuguese',
            'Dutch',
            'Swedish',
            'Norwegian',
            'Danish',
            'Polish',
            'Russian',
            'Chinese (Simplified)',
            'Chinese (Traditional)',
            'Japanese',
            'Korean',
            'Arabic',
            'Hindi',
        ];
    }

    public function render()
    {
        return view('components.language-select');
    }
}
