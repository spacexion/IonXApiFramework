<?php
require_once realpath(__DIR__."/../util/ArrayList.php");
require_once realpath(__DIR__."/ApiProject.php");
require_once realpath(__DIR__."/ApiObject.php");
require_once realpath(__DIR__."/ApiCommand.php");

/**
 * Class ApiRoutes
 *
 * Allow to quickly define root routes
 * It's basically an ArrayList of ApiProject
 */
class ApiRoutes {

    private $projects;

    public function __construct($projects=null) {
        $this->projects = new ArrayList("ApiProject");
        if($projects!=null && is_array($projects)) {
            $this->setProjects($projects);
        }
    }

    /**
     * @param ApiProject $project
     */
    public function addProject($project) {
        $this->projects->addObject($project, $project->getName());
    }

    /**
     * @param string $name
     */
    public function delProject($name) {
        $this->projects->delObject($name);
    }

    /**
     * @param string $name
     * @return ApiProject
     */
    public function getProject($name)
    {
        return $this->projects->getObject($name);
    }

    /**
     * @return array
     */
    public function getProjects()
    {
        return $this->projects->getObjects();
    }

    /**
     * @param array $projects
     */
    public function setProjects($projects)
    {
        $this->projects->setObjects($projects, true);
    }
}


?>