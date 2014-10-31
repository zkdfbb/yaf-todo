<?php
/**
 * @name MongoModel
 * @desc 数据获取类, 可以访问数据库，文件，其它系统等
 * @author digua
 */
class MongoModel {
    private $db;
    private $collection;

    public function __construct(){
        $this->db = Yaf_Registry::get("db");
        $this->collection = $this->db->list;
    }

    /*
    public function __construct() {
        $config = Yaf_Registry::get("config");
        $this->connection = new MongoClient( $server=$config['mongodb']['server'], $options=array("username"=>$config['mongodb']['username'],"password"=>$config['mongodb']['password']) );
        $this->db = $this->connection->$config['mongodb']['database'];
        $this->collection = $this->db->list;
    }

    public function __destruct() {
        $this->connection->close();
    }
    */

    public function query($option=array()) {
        $cursor = $this->collection->find();
        $result = array();
        foreach($cursor as $id => $value){
            $result[] = $value;
        }
        return $result;
    }

    public function insert($arrInfo) {
        try{
            return $this->collection->insert($arrInfo);
        }catch(Exception $e){
            return false;
        }
    }

    public function remove($option) {
        try{
            if(isset($option["id"])){
                $id = new MongoId($option["id"]);
                return $this->collection->remove(array("_id"=>(object)$id));
            }else{
                return $this->collection->remove($option);
            }
        }catch(Exception $e){
            return false;
        }
    }
}
