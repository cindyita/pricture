<?php

class Router 
{

    private $_page = array();
    private $_action = array();

    private $error404 = null;

    public function __construct($error404Page) 
    {
        $this->error404 = $error404Page;
    }

    public function add($page, $action = null) 
    {
        $this->_page[] = '/' . trim($page, '/');

        if ($action != null) 
        {
            $this->_action[] = $action;
        }
    }

    public function run() 
    {
        $pageGet = isset($_GET['page']) ? '/' . $_GET['page'] : '/';
        $matched = false;
        
        foreach ($this->_page as $key => $value) 
        {
            if (preg_match("#^$value$#", $pageGet)) 
            {
                $action = $this->_action[$key];
                $this->runAction($action);
                $matched = true;
            }
        }

        if (!$matched && $this->error404 != null) 
        {
            $this->runAction($this->error404);
        }
    }

    private function runAction($action) 
    {
        if($action instanceof \Closure)
        {
            $action();
        }  
        else 
        {
            $params = explode('@', $action);
            $obj = new $params[0];
            $obj->{$params[1]}();
        }
    }

}
?>