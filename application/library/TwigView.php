<?php

class TwigView implements Yaf_View_Interface {
    /**
     * @var Twig_Loader_Filesystem
     */
    protected $loader;
    /**
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * @var array
     */
    protected $context;

    /**
     * @param string $templateDir
     * @param array $options
     */
    function __construct($templateDir, $options = array()) {
        $this->loader = new Twig_Loader_Filesystem($templateDir);
        $options += array("debug" => true);
        $this->twig = new Twig_Environment($this->loader, $options);
        $this->twig->addExtension(new Twig_Extension_Debug());
        $this->context = array();
    }

    /**
     * @param string|array $name
     * @param mixed $value
     * @return bool
     */
    function assign($name, $value = null) {
        if (is_array($name)) {
            $this->context = array_merge($this->context, $name);
        } else {
            $this->context[$name] = $value;
        }
    }

    /**
     * @param string $tpl
     * @param array $tpl_vars
     * @return bool
     */
    function display($tpl, $tpl_vars = null) {
        echo $this->render($tpl, $tpl_vars);
    }

    /**
     * @return string
     */
    function getScriptPath() {
        $paths = $this->loader->getPaths();

        return reset($paths);
    }

    /**
     * @param string $tpl
     * @param array $tpl_vars
     * @return string
     */
    function render($tpl, $tpl_vars = null) {
        return $this->twig->loadTemplate($tpl)->render(
            is_array($tpl_vars) ? array_merge($this->context, $tpl_vars) : $this->context
        );
    }

    /**
     * @param string $templateDir
     */
    function setScriptPath($templateDir) {
        $this->loader->setPaths($templateDir);
    }

}
