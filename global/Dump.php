<?php
class Dump{
    static function dump(){
        $args = func_get_args();
        if(count($args)<1) return;
        echo "<pre>";
        foreach($args as $data){
            switch($data){
                case is_array($data):
                    print_r($data);
                    echo "<br>";
                    break;
                case is_string($data):
                    echo $data."<br>";
                    break;
                default:
                    var_dump($data);
            }
        }
    }
}
?>
