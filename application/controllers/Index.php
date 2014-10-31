<?php
/**
 * @name IndexController
 * @author digua
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class IndexController extends Yaf_Controller_Abstract {

    /**
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/sample/index/index/index/name/digua 的时候, 你就会发现不同
     */


    public function indexAction() {
        //1. fetch query
        //$get = $this->getRequest()->getQuery("get", "default value");

        $mongodb = new MongoModel();

        //配置文件
        $config = Yaf_Registry::get("config");

        //全局类Dump，放在/home/php/global下，需在php.ini里的yaf项里配置
        //Dump::dump($config);

        $this->getView()->assign("list",$mongodb->query());

        //4. render by Yaf, 如果这里返回FALSE, Yaf将不会调用自动视图引擎Render模板
        return TRUE;
    }


    public function AddAction(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $mongodb = new MongoModel();
            $content = $_POST["content"];
            //header("Content-type:text/json");
            $response = $this->getResponse();
            $response->setHeader("Content-type","text/json");
            if($content){
                $mongodb->insert(array("content"=>$content));
                $result = array("err"=>0);
            }else{
                $result = array("err"=>1,"err_msg"=>"content is lost");
            }
            echo json_encode($result);
            return False;
        }
    }


    public function DelAction(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            $mongodb = new MongoModel();
            $id = $_GET["id"];
            //header("Content-type:text/json");
            $response = $this->getResponse();
            $response->setHeader("Content-type","text/json");

            if($id){
                $mongodb->remove(array("id"=>$id));
                $result = array("err"=>0);
            }else{
                $result = array("err"=>1,"err_msg"=>"id is lost");
            }
            echo json_encode($result);
            return False;
        }
    }

}
