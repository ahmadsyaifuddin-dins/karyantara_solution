<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class PublicLayout extends Component
{
    // Daftarkan variabel title
    public $title;

    /**
     * Create a new component instance.
     * Kita beri nilai default jika halaman tidak mengirimkan title
     */
    public function __construct($title = 'Karyantara Solution - Web & Mobile App Development')
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.public');
    }
}
