<?php

class TestsiteController extends FrontControllerCore
{

    public $php_self = 'testsite'; // dostępne pod adresem [domena]/index.php?controller=testsite
    public $ssl = true;
    protected $firstProduct;

    public function initContent(){
        $this->setTemplate('catalog/_partials/custom_page');
        parent::initContent();
    }

    public function displayAjaxGetProducts() {
        $db = Db::getInstance();

        $request  = "SELECT * FROM ps_product ORDER BY id_product DESC LIMIT 10";
        $result = $db->executeS($request);

        $data = ['dane' => 'moje testowe dane'];

        if(!$this->errors) {
            $this->ajaxDie(Tools::jsonEncode([
                'data' => $data,
                'products' => $result
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