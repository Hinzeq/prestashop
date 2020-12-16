<?php

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Adapter\Category\CategoryProductSearchProvider;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\SortOrder;

if (!defined('_PS_VERSION_')) {
    exit;
}

Class Ps_HomeText extends Module 
{

    public function __construct()
    {
        $this->name = 'ps_hometext';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'Wojciech Hinz';

        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.5',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;
        
        parent::__construct();

        $this->displayName = $this->l('Home Text');
        $this->description = $this->l('Wyświetla polecane w tym tygodniu!');
        $this->confirmUninstall = $this->l('Czy na pewno odinstalować moduł?');
    }

    public function install()
    {
        if (Shop::isFeatureActive())
            Shop::setContext(Shop::CONTEXT_ALL);

        return parent::install() &&
            $this->registerHook('displayHome');
    }

    public function uninstall()
    {
        if (!parent::uninstall() || !Configuration::deleteByName('val'))
            return false;
        return true;
    }

    public function hookDisplayHome($params)
    {
        $products = $this->getProducts();
        $this->context->smarty->assign(
            array(
                'prod' => $products
            )
        );
        return $this->display(__FILE__, 'ps_hometext.tpl');
    }


    protected function getProducts()
    {
        $category = new Category((int) Configuration::get('HOME_FEATURED_CAT'));

        $searchProvider = new CategoryProductSearchProvider(
            $this->context->getTranslator(),
            $category
        );

        $context = new ProductSearchContext($this->context);

        $query = new ProductSearchQuery();

        $nProducts = Configuration::get('HOME_FEATURED_NBR');
        if ($nProducts < 0) {
            $nProducts = 12;
        }

        $query
            ->setResultsPerPage($nProducts)
            ->setPage(1)
        ;

        if (Configuration::get('HOME_FEATURED_RANDOMIZE')) {
            $query->setSortOrder(SortOrder::random());
        } else {
            $query->setSortOrder(new SortOrder('product', 'position', 'asc'));
        }

        $result = $searchProvider->runQuery(
            $context,
            $query
        );

        $assembler = new ProductAssembler($this->context);

        $presenterFactory = new ProductPresenterFactory($this->context);
        $presentationSettings = $presenterFactory->getPresentationSettings();
        $presenter = $presenterFactory->getPresenter();

        $products_for_template = [];

        foreach ($result->getProducts() as $rawProduct) {
            $products_for_template[] = $presenter->present(
                $presentationSettings,
                $assembler->assembleProduct($rawProduct),
                $this->context->language
            );
        }

        return $products_for_template;
    }

}
