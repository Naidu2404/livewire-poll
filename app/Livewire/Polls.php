<?php

namespace App\Livewire;

use App\Models\Option;
use Livewire\Component;

class Polls extends Component
{
    //we define the listeners in a protected variable named $listeners
    protected $listeners = [
        //we addd the event we listen mapping to the method we need to perform if the event is listened
        'pollCreated' => 'render',
    ];

    public function render()
    {
        //rettrieving all the data of polls stored inside the database
        $polls = \App\Models\Poll::with('options.votes')->latest()->get();

        return view('livewire.polls',['polls' => $polls]);
    }

    //for adding votes
    public function vote(Option $option) {
        // $option = \App\Models\Option::findOrFail($optionId);
        //no need to fetch as we used rout binding

        $option->votes()->create();
    }
}
