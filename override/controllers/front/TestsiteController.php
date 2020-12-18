<?php

class TestsiteController extends FrontControllerCore
{

    public $php_self = 'testsite'; // dostępne pod adresem [domena]/index.php?controller=testsite
    public $ssl = true;
    protected $firstProduct;

    public function initContent(){
        parent::initContent();
        $this->context->smarty->assign(
            array(
              'valw' => 'wartość'
            ));
        $this->setTemplate('catalog/_partials/custom_page');
    }

}