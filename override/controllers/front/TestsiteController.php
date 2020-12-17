<?php

class TestsiteController extends FrontControllerCore
{

    public $php_self = 'testsite'; // dostępne pod adresem [domena]/index.php?controller=testsite
    public $ssl = true;
    protected $firstProduct;

    public function initContent(){
        //die('działa poprawnie :)');
        parent::initContent();
        $this->setTemplate('new-index');
    }

}