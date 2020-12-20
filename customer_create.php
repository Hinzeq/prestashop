<?php

use PrestaShop\PrestaShop\Core\Crypto\Hashing;
use PrestaShop\PrestaShop\Classes;

include(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');

$customers = [
    ['login' => 'dawid.fedyk@avenirmed.com', 'password' => 'Sx8DsMkwZ2'],
    ['login' => 'jan.kowalski@domenatest123.org', 'password' => 'M2g59HU2TH'],
    ['login' => 'karol.nowak@domenatest123.org', 'password' => 'iRq0CpUV5w'],
    ['login' => 'joanna.kowalska@domenatest123.org', 'password' => 'ca7Bydz4zd'],
    ['login' => 'katarzyna.wojcik@domenatest123.org', 'password' => 'jkAfXdR00W'],
    ['login' => 'kamila.kowalczyk@domenatest123.org', 'password' => 'L2xaEpHtcR'],
    ['login' => 'marcin.wisniewski@domenatest123.org', 'password' => 'j8ypoRmw8O'],
    ['login' => 'andrzej.mirecki@domenatest123.org', 'password' => 'h2eko7a4Sp'],
    ['login' => 'zbigniew.nowak@domenatest123.org', 'password' => '7ooUSdcjAQ'],
    ['login' => 'artur.krol@domenatest123.org', 'password' => 'HpCpeQwiGi']
];

foreach ($customers as $person) {
    $customer = new Customer();
    $crypto = new Hashing();

    $customer->id_default_group = 4; // create group "stali klienci", id = 4, table = ps_group
    $customer->id_lang = 1;
    $customer->email = $person['login'];
    
    $customer->firstname = getName('first', $person['login']);
    $customer->lastname = getName('second', $person['login']);

    $customer->passwd = $crypto->hash($person['password']);

    $customer->active = 1;
    $customer->data_add = date("Y-m-d h:i:s");
    
    $customer->add();

    // here I have a problem, this method after var_dump gives false
    Mail::send(
        (int)(Configuration::get('PS_LANG_DEFAULT')),
        'account',
        'Witaj!',
        [
            '{email}' => 'wojciech.hinz@prestashop.pl',
            '{message}' => 'Konto zostało poprawnie dodane.
                Login: '.$person['login'],
                'Hasło: '.$person['password']
        ],
        $customer->email
    );
}


function getName($par, $name) {

    $firstname = explode('.', $name);

    if($par == 'first') {
        return $firstname[0];
    }

    else if($par == 'second') {
        $secondname = explode('@', $firstname[1]);
        return $secondname[0];
    }

}