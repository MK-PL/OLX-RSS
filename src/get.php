<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
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
  
  $context = stream_context_create(array('http' => array('header' => 'User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0')));
  
  $html = file_get_html($baseUrl, false, $context, 0);
  
  if(($html->find('.pager', 0))) {
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
    
    
    foreach($page->find('#offers_table .wrap') as $article) {

        $item[$j] = new Item();
        if($article->find('.detailsLink strong', 0)->plaintext != ''){
          $item[$j]->title($article->find('.detailsLink strong', 0)->plaintext);
          $item[$j]->url(strstr($article->find('.detailsLink', 0)->href, '#', true));
          $item[$j]->guid(strstr($article->find('.detailsLink', 0)->href, '#', true));
        } else {
          $item[$j]->title($article->find('.detailsLinkPromoted strong', 0)->plaintext);
          $item[$j]->url(strstr($article->find('.detailsLinkPromoted', 0)->href, '#', true));
          $item[$j]->guid(strstr($article->find('.detailsLinkPromoted', 0)->href, '#', true));
        }

        
        $price = $article->find('.price', 0)->plaintext;
        $bcell = $article->find('td.bottom-cell')[0];
        $location = $bcell->find('.breadcrumb', 0)->plaintext;
        $date = trim($bcell->find('.breadcrumb', 1)->plaintext);
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
                <a href="'.strstr($article->find('.detailsLink', 0)->href, '#', true).'" target="_blank">
                  <center>
                    <img src="'.$article->find('.linkWithHash img', 0)->attr['src'].'">
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

  header("Content-Type: text/xml; charset=utf-8");
	echo $feed;
?>
