<?php
/**
 * @name Bootstrap
 * @author digua
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf_Bootstrap_Abstract{

    public function _initConfig() {
        //把配置保存起来
        $this->config = Yaf_Application::app()->getConfig();
        Yaf_Registry::set('config', $this->config);
        if($this->config->get('debug')){
            ini_set('display_errors', 1);
            ini_set('error_reporting', E_ALL);
        }
    }

    public function _initPlugin(Yaf_Dispatcher $dispatcher) {
        //注册一个插件
        $objSamplePlugin = new SamplePlugin();
        $dispatcher->registerPlugin($objSamplePlugin);
    }

    public function _initRoute(Yaf_Dispatcher $dispatcher) {
        //在这里注册自己的路由协议,默认使用简单路由
        //从配置文件添加
        $router = Yaf_Dispatcher::getInstance()->getRouter();
        $routes = $this->config->routes;
        if(!empty($routes)){
            $router->addConfig($routes);
        }

        /*
        $route = new Yaf_Route_Regex(
            '/product/([\w]+)',
            array(
                'module' => 'index',
                'controller' => 'index',
                'action' => 'info'
            )
        );
        $router->addRoute('dummy',$route);
        */
    }


#    public function _initLocalNamespace(){
#        /* 全局类，自动加载，做以下事情
#        *  修改/etc/php.ini , 增加 yaf.library 全局类目录路径，重启php-fpm
#        *  在全局类目录下新建文件，多层目录使用 外层目录_内层目录_类名的方式定义类的名字
#        *  本地类，需使用registerLocalNamespace()注册
#        */
#
#        //注册本地类，凡是以Local开头的都是本地类
#        Yaf_Loader::getInstance()->registerLocalNamespace(array("Local","Twig",""));
#      }
#

    public function _initView(Yaf_Dispatcher $dispatcher){
        //在这里注册自己的view控制器，例如smarty,firekylin
        $twig = new Twig_View( APPLICATION_PATH . "/application/views/");
        $dispatcher->setView($twig);
    }



    public function _initDatabase(){
        $config = $this->config;
        $connection = new MongoClient( $server=$config['mongodb']['server'], $options=array("username"=>$config['mongodb']['username'],"password"=>$config['mongodb']['password']) );
        $db = $connection->$config['mongodb']['database'];
        Yaf_Registry::set('db', $db);
    }

}
