<?php

namespace App\Services;

use App\Repositories\ProjectRepository;

class ProjectService
{
    
    protected $projectRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function saveProject($projectRequest)
    {
        // dd($projectRequest);

        if (!empty($projectRequest['project_logo'])) {
            $projectLogo = $projectRequest['project_logo'];
        }
    }
}
