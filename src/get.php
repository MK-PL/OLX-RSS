<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

	include 'simple_html_dom.php';
	include 'Item.php';
	include 'Feed.php';
	include 'RSS2.php';
  
  date_default_timezone_set('UTC');
  setlocale(LC_ALL, array( "pl_PL", "polish_pol" ));
	use \FeedWriter\RSS2;
  
	$TestFeed = new RSS2;
	$TestFeed->setTitle($_GET['url']);
  
  $baseUrl = html_entity_decode($_GET['url']);
  $baseUrl = str_replace("&view=galleryWide", "", $baseUrl);
  $baseUrl = str_replace("?view=galleryWide", "", $baseUrl);
  $baseUrl = trim($baseUrl, '/');
  
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

        $item[$j] = $TestFeed->createNewItem();
        if($article->find('.detailsLink strong', 0)->plaintext != ''){
          $item[$j]->setTitle($article->find('.detailsLink strong', 0)->plaintext);
          $item[$j]->setLink($article->find('.detailsLink', 0)->href);
        } else {
          $item[$j]->setTitle($article->find('.detailsLinkPromoted strong', 0)->plaintext);
          $item[$j]->setLink($article->find('.detailsLinkPromoted', 0)->href);
        }

        
        $price = $article->find('.price', 0)->plaintext;
        $location = $article->find('.marginbott5', 0)->plaintext;
        $date = $article->find('p.x-normal', 0)->plaintext;
        if (strpos($date, 'dzisiaj')) {
          $date = strftime('%e %b');
        } elseif (strpos($date, 'wczoraj')) {
          $date = strftime('%e %b', strtotime('-1 days'));
        }
      
        $item[$j]->setDescription ('
        <table cellpadding="10">
          <tbody>
            <tr>
              <td width="300" bgcolor="#eeeeee">
                <a href="'.$article->find('.detailsLink', 0)->href.'" target="_blank">
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
      
        $TestFeed->addItem($item[$j]);
        $j++;
    }
  }

	$TestFeed->printFeed();
?>