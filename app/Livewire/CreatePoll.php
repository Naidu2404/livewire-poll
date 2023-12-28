<?php

namespace App\Livewire;

use App\Models\Poll;
use Livewire\Component;

class CreatePoll extends Component
{
    //the variables defined can be used inside the views
    public $title;
    //the title can now be used inside the view

    //we will add the options for the poll
    public $options = ['First'];

    //we can customise the rror messages using the protected messages
    protected $messages = [
        'options.*' => "The Option can't be empty"
    ];

    //to add realtime validation to the form we copied the method to do so from livewire docs
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    //we need to define the rules of validation as an array of type protected
    protected $rules = [
        'title'=> 'required|min:3|max:255',
        'options' => 'required|min:1|max:10',
        //for validating contents of the options array
        'options.*' =>'required|min:1|max:255'
    ];


    public function render()
    {
        return view('livewire.create-poll');
    }

    //we can define actions as we wish same as methods
    public function addOption(){
        $this->options[] = '';
    }

    //action to remove an option from the options using the index
    public function removeOption($index) {
        unset($this->options[$index]);
        //if we unset an option there is a gap in the indexes formed due to this
        //we need to make the indexes continuous again
        $this->options = array_values($this->options);
    }

    //we create a poll
    public function createPoll() {
        //firstly we need to validate the form 
        $this->validate();



        //we create a poll object
        // $poll = Poll::create([
        //     'title'=> $this->title,
        // ]);

        // //we iterate through the options
        // foreach ($this->options as $optionName) {
        //     $poll->options()->create(['name' => $optionName]);
        // }

        //the alternative way without creating variables to add data into tables is

        Poll::create([
            'title' => $this->title,
        ])->options()->createMany(
            //we need an array mapping name and the value for options
            collect($this->options)
            ->map(fn($option) => ['name' => $option])
            ->all()
        );

        //we reset the form affter submission using the reset function
        $this->reset(['title','options']);

        //after adding the ;oll to the database we emit an event so that it can be listened and the values of polls updates in real time
        // $this->emit(''); is in the old version of livewire
        $this->dispatch('pollCreated');
    }
}
