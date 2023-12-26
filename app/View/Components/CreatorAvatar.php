<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class CreatorAvatar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(private ?string $path, private string $class = '', private string $alt = '')
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $source = $this->path ? Storage::temporaryUrl($this->path, now()->addHour(1)) : config('app.url').'/images/avatar.webp';

        return view('components.avatar', [
            'source' => $source,
            'class' => $this->class,
            'alt' => $this->alt,
        ]);
    }
}
