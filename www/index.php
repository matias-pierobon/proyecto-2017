<?php
require_once "../vendor/autoload.php";

use Hospital\Application;
use Melody\Http\Request;

$request = Request::createFromGlobals();

$app = new Application();

?>

<pre><code><?php var_dump($request->getPathInfo()) ?></code></pre>
