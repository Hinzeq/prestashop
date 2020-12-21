<?php

class TestsiteController extends FrontControllerCore
{

    public $php_self = 'testsite'; // [domena]/index.php?controller=testsite
    public $ssl = true;
    protected $firstProduct;

    public function initContent(){
        $this->setTemplate('catalog/_partials/custom_page');
        parent::initContent();
    }

    public function displayAjaxGetProducts() {
        $db = Db::getInstance();

        $request  = "SELECT * FROM ps_product ORDER BY id_product DESC LIMIT 10";
        $products_info = $db->executeS($request);

        $request  = "SELECT * FROM ps_product_lang ORDER BY id_product DESC LIMIT 10";
        $products_name = $db->executeS($request);

        if(!$this->errors) {
            $this->ajaxDie(Tools::jsonEncode([
                'products_info' => $products_info,
                'products_name' => $products_name,
                'products_img' => $products_img,
                'success' => true
            ]));
        }

        else {
            $this->ajaxDie(Tools::jsonEncode([
                'hasError' => true,
                'errors' => $this->errors
            ]));
        }
    }

    

}