<?php

namespace App\Livewire\Projects;

use Livewire\Attributes\Validate;
use Livewire\Component;

class FormModal extends Component
{
    #[Validate('required|string|max:100')]
    public $name = null;

    #[Validate('required|string|max:255')]
    public $description = null;

    #[Validate('required|string')]
    public $deadline = null;

    #[Validate('required|string')]
    public $status = 'pending';

    #[Validate('nullable|image|max:5120')]
    public $project_logo = null;


    // Function: saveProject

    public function saveProject()
    {
        #Validating form here
        $validatedProjectRequest = $this->validate();    
    }

    public function render()
    {
        return view('livewire.projects.form-modal');
    }
}
