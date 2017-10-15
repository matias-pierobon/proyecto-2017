<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 3:57 PM
 */

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Hospital\Application;

$app = new Application();
$app->boot();
$entityManager = $app->getContainer()->get('entityManager');

return ConsoleRunner::createHelperSet($entityManager);