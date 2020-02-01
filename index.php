<?php
define('ROOT_PATH', __DIR__) ;
require('classes/HtmlDocument.class.php');
$page= isset($_GET['page']) ? $_GET["page"] : 'index';

if(isset($_GET))
    $doc = new HtmlDocument($page);
    $doc->applyTemplate('defaut');
    $doc->render();
?>