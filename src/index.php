<?php
include ("DoubleLink.php");
include ("Node.php");

use \DoubleLink\DoubleLink;
use \Node\Node;


echo "hallo Welt" ;


$list = new DoubleLink() ;

for ($i=0; $i<5; $i++){
    $node = new Node($i);
    $list->addNode($node);
}

//var_dump($list->walkDoubleLink(DoubleLink::walk_backwards));
var_dump($list->walkDoubleLink());

$list->deleteNode(0);
$list->deleteNode(4);

var_dump($list->walkDoubleLink());

