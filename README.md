[![Build Status](https://travis-ci.org/dshovchko/php_UAPAY.svg?branch=master)](https://travis-ci.org/dshovchko/php_UAPAY)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dshovchko/php_UAPAY/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dshovchko/php_UAPAY/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/dshovchko/php_UAPAY/badge.svg?branch=master)](https://coveralls.io/github/dshovchko/php_UAPAY?branch=master)

php_UAPAY
=========

PHP бібліотека, що надає інтерфейс для взаємодії c API інтернет еквайрингу UAPAY.

### Встановлення

```
composer require dshovchko/php_uapay
```

### Зауваження

На данний час бібліотека реалізує використання операцій з типом списання PAY "списання". Операції пов’язані з типом HOLD виконати за допомогою бібліотеки неможливо.

### Використання

Тип списання PAY дозволяє виконати операції створення сесії, створення замовлення, скасування замовлення, перегляд інформації по раніше зробленому замовленню. А також отримувати інформування про платіж.

Процес поповнення рахунку складається з наступних кроків:

 - спочатку ви маєте створити сесію в системі UAPAY;
 - якщо буде створено сесію, то далі маєте створити замовлення;
 - якщо замовлення буде успішно створене, то ви у відповіді отримаєте URL для редіректа на сторінку оплати;
 - далі робите перехід на отриманий URL (все, тепер ваша система далі не контролює процесс);
 - на сторінці оплати робиться платіж;
 - далі керування повертається до вас через інформування про платіж.

Створимо конфігураційний файл:
```
<?php

return array(

    'clientId'		=> '1234',
    'api_uri'		=> 'https://api.demo.uapay.ua',
    'jwt'		=> array(
	'using'		=> true,
	'UAPAY_pubkey'	=> 'uapay.pub',
	'our_privkey'	=> 'private.pem',
    ),
);
```

Створимо файл ініціалізації журрналювання:
```
<?php

namespace UAPAY;

Log::set(new Logger(
        realpath('каталог з логами'.DIRECTORY_SEPARATOR,	// log path
        'uapay',	// prefix for log files (default 'my')
        true		// enable/disable debug (default false)
));
```

Тепер файл створення сесії, замовлення та отриманя URL сторінки оплати:
```
<?php

require 'vendor/autoload.php';
require 'щлях до файла ініціалізації журналювання';

$options = include('шлях до конфігураційного файлу');

try
{
    /**
     *      session create BEGIN
     */
    $request = new \UAPAY\Sessions\Create\Request($options);
    $response = $request->send();

    $sesid = $response->id();
    /**
     *      session create END
     */

    /**
     *      create session in your system
     */
    //
    // тут записуємо сесію в нашій системі
    // та створюємо масив $data
    // зміст масива, це структура payLoad object
    // дивись в описі API UAPAY

    /**
     *      order create BEGIN
     */
    $request = new \UAPAY\Orders\Create\Request($options);
    $request->sessionId($sesid);
    $request->data($data);
    $response = $request->send();

    $orderid = $response->id();
    /**
     *      order create END
     */

    /**
     *      update session data with order id
     */
    // тут поновлюємо дані в нашій системі
    // додаємо дані замовлення

    /**
     *      generate return data
     */
    $ret = array(
        'status' => 1,
        'paymentPageUrl' => $response->paymentPageUrl()
    );
}
catch (\Exception $e)
{
    /**
     *      Attention! Got an error!
     */
    UAPAY\Log::instance()->add('an error occured during a request');

    $ret = array(
        'status' => 0,
        'error' => 'an error occured during a request'
    );
}

/**
 *      Return json
 */
ob_clean();
header("Content-Type: application/json; charset=utf-8");
echo json_encode($ret);
exit;
```

Нарешті файл який викликається при інформуванні про платіж.
```
require 'vendor/autoload.php';
require 'щлях до файла ініціалізації журналювання';

$options = include('шлях до конфігураційного файлу');

try
{
    /**
     *      get callback data
     */
    $request = new \UAPAY\Callback($options);

    /**
     *      update session data with callback data
     */
    // обвлюємо дані у нашій системі
    // та зараховуємо платіж на баланс
}
catch (\Exception $e)
{
    /**
     *      Attention! Got an error!
     */
    UAPAY\Log::instance()->add('an error occured during a callback request');
}
```
