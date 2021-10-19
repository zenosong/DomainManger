<?php


namespace app\common\library;


use GuzzleHttp\Client;
use PHPHtmlParser\Dom;
use think\Exception;
use think\helper\Str;

class Domain
{

    protected $config = [];
    protected $client = null;

    public function __construct(array $config = [])
    {
        $this->client = new Client(array_merge([
            'base_uri' => 'https://whoisdog.com/whois.lookup',
            'timeout'  => 10
        ], $config));
    }

    /**
     * @param $domain
     * @return array
     * @throws Exception
     */
    public function whois($domain)
    {
        try {
            $response = $this->client->get('?' . http_build_query([
                    'domain' => $domain,
                    'lookup' => 'whois'
                ]));

            if (200 != $response->getStatusCode()) {
                throw new Exception('whois查询服务不可用');
            }

            $content = $response->getBody()->getContents();

            $result = [];
            if ($content) {
                $dom = new Dom();
                $dom->loadStr($content);
                $innerHtml = $dom->find('div[class="wdData"]')->offsetGet(0)->innerHtml();
                $whois = explode('<br />', $innerHtml);

                foreach ($whois as $item) {
                    $i = strpos($item, ':');
                    $key = Str::studly(Str::substr($item, 0, $i));
                    if (!$key) {
                        continue;
                    }
                    $value = strip_tags(trim(Str::substr($item, $i + 1)));
                    if (isset($result[$key])) {
                        $temp = $result[$key];
                        unset($result[$key]);
                        $result[$key][] = $temp;
                        $result[$key][] = $value;
                    } else {
                        $result[$key] = $value;
                    }
                }
            }

            return $result;
        } catch (\Exception $exception) {
            throw new Exception('whois查询服务不可用');
        }
    }
}