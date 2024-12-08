<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CommentsList extends Component
{
    public $comments;

    public function __construct($comments)
    {
        $this->comments = $comments;
    }

    public function render()
    {
        return view('components.comments-list');
    }
}
