<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL & ~E_NOTICE);

	include 'simple_html_dom.php';
	include 'removeAccents.php';
	include 'ItemInterface.php';
	include 'Item.php';
	include 'FeedInterface.php';
	include 'Feed.php';
	include 'ChannelInterface.php';
	include 'Channel.php';
	include 'SimpleXMLElement.php';

  use Bhaktaraz\RSSGenerator\Item;
  use Bhaktaraz\RSSGenerator\Feed;
  use Bhaktaraz\RSSGenerator\Channel;
  
  date_default_timezone_set('UTC');
  setlocale(LC_ALL, array( "pl_PL", "polish_pol" ));

  $feed = new Feed();
  $channel = new Channel();
  
  $baseUrl = html_entity_decode($_GET['url']);
  $baseUrl = str_replace("&view=galleryWide", "", $baseUrl);
  $baseUrl = str_replace("?view=galleryWide", "", $baseUrl);
  $baseUrl = trim($baseUrl, '/');
  $baseUrl = urldecode($baseUrl);
  $baseUrl = remove_accents($baseUrl);
  
  $channel
    ->title($_GET['url'])
    ->description("OLX RSS")
    ->url($_GET['url'])
    ->language('pl')
    ->appendTo($feed);
  
  $context = stream_context_create(array('https' => array('header' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36')));
  
  $html = file_get_html($baseUrl, false, $context, 0);

  if(($html->find('ul.pagination-list li', 0))) {
    $numberOfPages = 2;
  } else {
    $numberOfPages = 1;
  }

  $j = 0;

  for ($i = 1; $i <= $numberOfPages; $i++) {
    if (strpos($baseUrl, '?')) {
      $page = file_get_html($baseUrl.'&page='.$i, false, $context, 0);
    } else {
      $page = file_get_html($baseUrl.'/?page='.$i, false, $context, 0);
    }
    
    $resultsTable = $page->find('.listing-grid-container');
    
    if($resultsTable) {
      foreach($page->find("div[data-cy='l-card']") as $article) {
          $item[$j] = new Item();
          if($article->find('h6', 0)->plaintext != ''){
            $item[$j]->title($article->find('h6', 0)->plaintext);
              $url = $article->find('a', 0)->href;
            if (strpos($url, 'https://www.otomoto.pl') !== false) {

              $item[$j]->url($url);
              $item[$j]->guid($url);
            } else {
                $url = "https://www.olx.pl".$url;
              $item[$j]->url($url);
              $item[$j]->guid($url);
            }
          } else {
            $item[$j]->title($article->find('.detailsLinkPromoted strong', 0)->plaintext);
            if (strpos($article->find('.detailsLinkPromoted', 0)->href, 'https://www.otomoto.pl') !== false) {
              $item[$j]->url($article->find('.detailsLinkPromoted', 0)->href);
              $item[$j]->guid($article->find('.detailsLinkPromoted', 0)->href);
            } else {
              $item[$j]->url(strstr($article->find('.detailsLinkPromoted', 0)->href, '#', true));
              $item[$j]->guid(strstr($article->find('.detailsLinkPromoted', 0)->href, '#', true));
            }
          }

          $price = $article->find('p[data-testid="ad-price"]', 0)->plaintext;
          $l = $article->find('p[data-testid="location-date"]', 0)->plaintext;
          $l2 = explode(" - ", $l, 2);
          $location = trim($l2[0]);
          $date = trim($l2[1]);
          if (strpos($date, 'dzisiaj')) {
            $date = strftime('%e %b');
          } elseif (strpos($date, 'wczoraj')) {
            $date = strftime('%e %b', strtotime('-1 days'));
          }
        
          $item[$j]->description('
          <table cellpadding="10">
            <tbody>
              <tr>
                <td width="300" bgcolor="#eeeeee">
                  <a href="'.$url.'" target="_blank">
                    <center>
                      <img src="'.$article->find('img', 0)->attr['src'].'">
                    </center>
                  </a>
                </td>
                <td>
                  <p>Miejscowość: <strong>'.trim($location).',</strong> Wystawiono: '.$date.'</p><h1>Cena: '.$price.'</h1>
                </td>
              </tr>
            </tbody>
          </table><hr>');
        
          $item[$j]->appendTo($channel);
          $j++;
      }
    }
  }

  header("Content-Type: text/xml; charset=utf-8");
	echo $feed;
