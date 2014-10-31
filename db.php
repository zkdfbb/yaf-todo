<?php

$m = new MongoClient( $server="mongodb://localhost:27017", $options=array("username"=>"slave","password"=>"slave"));  //创建一个连接
$dd = "todo";
$db = $m->$dd;
$collection = $db->list;  //选择集合，也就是mysql里对应的表

/*
$doc = array(
    "name" => "MongoDB",
    "type" => "database",
    "count" => 1,
    "info" => (object)array("x"=>203,"y"=>201)
);
$collection->insert($doc);
 */

$cursor = $collection->find();  //查询，一条是findOne
foreach($cursor as $id => $value ){
    echo "_id is $id:\n";
    var_dump($value);
}
?>
