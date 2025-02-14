<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class PostComments extends Component
{
    use WithPagination;
    public Post $post;

    #[Rule('required|min:3|max:255')]
    public string $comment;
    public function postComment()
    {
        if(auth()->guest()) {
            return;
        }
        
        $this->validateOnly('comment');
        
        $this->post->comments()->create([
            'user_id' => auth()->id(),
            'post_id' => $this->post,
            'comment' => $this->comment,
        ]);

        $this->reset('comment');
    }

    #[Computed()]
    public function commments()
    {
        return $this?->post?->comments()->with('user')->latest()->paginate(5);
    }
    public function render()
    {
        return view('livewire.post-comments');
    }
}
