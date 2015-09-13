<?php

namespace IonXLab\IonXApi\routes;
use IonXLab\IonXApi\util\ArrayCollection;

/**
 * Class ApiRoutes
 *
 * Allow to quickly define root routes
 */
class ApiRoutes {

    /**
     * @var ArrayCollection
     */
    private $projects;

    /**
     * @param ApiProject[] $projects=null
     */
    public function __construct($projects=null) {
        $this->projects = new ArrayCollection("IonXApi\\routes\\ApiProject");
        $this->setProjects($projects);
    }

    /**
     * @param string $projectName
     * @param ApiProject $project
     */
    public function addProject($projectName, $project) {
        $this->projects->addAt($projectName, $project);
    }

    /**
     * @param string $name
     */
    public function delProject($name) {
        $this->projects->remove($name);
    }

    /**
     * @param string $name
     * @return ApiProject
     */
    public function getProject($name) {
        return $this->projects->get($name);
    }

    /**
     * @return ArrayCollection
     */
    public function getProjects() {
        return $this->projects;
    }

    /**
     * @param ApiProject[] $projects
     */
    public function setProjects($projects) {
        if(!is_null($projects) && is_array($projects)) {
            foreach($projects as $project) {
                $this->projects->addAt($project->getName(), $project);
            }
        }
    }
}


?>