<?php

namespace Application\Service;

require_once('phpQuery/phpQuery-onefile.php');

class ParserService
{
    private const BASE_URL = 'https://www.coingecko.com/en';

    public function __construct()
    {
    }

    public function request(): array
    {
        return $this->getTopCoins();
    }

    private function getTopCoins(): array
    {
        $html = file_get_contents(static::BASE_URL);
        $dom = \phpQuery::newDocument($html);

        $topCoins = [];
        $coinsTable = $dom->find('.coin-table table:eq(0) tbody tr');
        foreach ($coinsTable as $tr) {
            if (count($topCoins) == 65) {
                break;
            }

            $trDom = pq($tr);
            $name = $trDom->find('td[class*="coin-name"]');
            $price = $trDom->find('td[class*="td-price"] > span[data-target="price.price"]');
            $topCoins[] = [
                'name' => $name->attr('data-sort'),
                'price' => $price->text(),
                'timestamp' => (new \DateTime())->format('m.d.Y H:i:s')
            ];
        }

        \phpQuery::unloadDocuments();

        return $topCoins;
    }
}