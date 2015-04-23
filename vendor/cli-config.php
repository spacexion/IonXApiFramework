<?php

require_once realpath(__DIR__."../EntityMgr.php");

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet(EntityMgr::$entityManager);
?>