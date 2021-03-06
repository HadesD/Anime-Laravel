<?php

namespace App\Http\Controllers\API\Watch\GetLink;

use Illuminate\Http\Request;
use App\Http\Controllers\API\Watch\GetLinkController;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;

class Anime47Com extends GetLinkController
{
  protected function canGetLink()
  {
    parent::canGetLink();

    $parseUrl = parse_url($this->url);
    $client = new Client([
      'base_uri' => 'http://'.$parseUrl['host'],
      'http_errors' => false,
      'allow_redirects' => false,
      'headers' => [
        'X-Requested-With'          => 'XMLHttpRequest',
        'Referer'                   => $parseUrl['host'],
        'Upgrade-Insecure-Requests' => 1,
        //'User-Agent'                => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1',
      ],
    ]);

    $res = $client->request('GET', $parseUrl["path"], []);
    if ($res->getStatusCode() !== 200)
    {
      return false;
    }

    $dom = new Crawler((string)$res->getBody());
    $jsonPlay = $dom->filter('#player-area script');
    if (count($jsonPlay) === 0)
    {
      return fasle;
    }
    $rpl = [
      'bitplayer(' => '',
      ');'         => '',
      'div:'       => '"div":',
      'link:'      => '"link":',
      'player:'    => '"player":',
      'style:'     => '"style":',
      'version:'   => '"version":',
    ];
    $json = trim(str_replace(array_keys($rpl), array_values($rpl), $jsonPlay->text()));
    $json_decode = json_decode($json, true);
    if (isset($json_decode['link']) === false)
    {
      return false;
    }

    $res = $client->request('GET', sprintf('/player/dien_thoai.php?url=%s', $json_decode['link']), []);
    if ($res->getStatusCode() !== 200)
    {
      return false;
    }

    $dom = new Crawler((string)$res->getBody());
    $linkList = $dom->filter('a');
    if (count($linkList) === 0)
    {
      return false;
    }
    $link = &$this->results['srcs'];
    $linkList->reduce(function (Crawler $node, $i) use (&$link) {
      $link[] = [
        'quality' => $node->text(),
        'src' => $node->attr('href'),
        'type' => 'video/mp4',
      ];
    });

    return true;
  }
}
