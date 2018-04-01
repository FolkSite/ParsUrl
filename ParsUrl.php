<?php

/**
 * AjaxPars
 * release 0.0.1
 */

namespace Indeximstudio\ParsUrl;

if (!defined('MODX_BASE_PATH')) {
    die('What are you doing? Get out of here!');
}

class ParsUrl
{
    /**
     * @param string $url
     * @param string $post
     * @return mixed
     */
    static public function request($url = '', $post = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); // отправляем на
        curl_setopt($ch, CURLOPT_HEADER, 0); // пустые заголовки
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // следовать за редиректами
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 5000);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);// таймаут4
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);// время на выполнения скрипта

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); // сохранять куки в файл
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 YaBrowser/16.6.0.8149 Yowser/2.5 Safari/537.36");
        curl_setopt($ch, CURLOPT_POST, $post !== 0); // использовать данные в post
        if ($post)
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $data['page'] = curl_exec($ch);
        $data['info'] = curl_getinfo($ch);
        $data['error'] = curl_error($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * чтение страницы после авторизации
     * @param string $url
     * @param string $post
     * @return mixed
     */
    static public function read($url = '', $post = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // откуда пришли на эту страницу
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 5000);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);// таймаут4
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);// время на выполнения скрипта
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //отсылаем серверу COOKIE полученные от него при авторизации
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
        curl_setopt($ch, CURLOPT_POST, $post !== 0); // использовать данные в post
        if ($post)
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $data['page'] = curl_exec($ch);
        $data['info'] = curl_getinfo($ch);
        $data['error'] = curl_error($ch);

        curl_close($ch);
        return $data;
    }

    static public function read_ajax($url = '', $post = '', $headers = [])
    {
        if (count($headers) == 0) {
            $headers = array(
                "POST " . $url . " HTTP/1.0",
                "Content-type: application/x-www-form-urlencoded; charset=UTF-8",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "Origin:" . $url . "",
                "Referer:" . $url . "/as/",
                "X-Requested-With:XMLHttpRequest"
            );
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // откуда пришли на эту страницу
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_HTTP200ALIASES, array(400, 403));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 5000);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);// таймаут4
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);// время на выполнения скрипта
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //отсылаем серверу COOKIE полученные от него при авторизации
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
        curl_setopt($ch, CURLOPT_POST, $post !== 0); // использовать данные в post
        if ($post)
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $data['page'] = curl_exec($ch);
        $data['info'] = curl_getinfo($ch);
        $data['error'] = curl_error($ch);

        curl_close($ch);
        return $data;
    }
}
