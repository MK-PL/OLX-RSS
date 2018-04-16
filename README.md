# OLX RSS
OLX RSS jest generatorem kanału RSS do serwisu OLX.pl, który pozwala na spersonalizowanie wszystkich parametrów wyszukiwania.

## Jak zainstalować?

Skopiuj pliki na serwer obsługujący PHP w wersji >= 5.3 i otwórz w przeglądarce adres http://ADRES_SERWERA/index.html

## Jak stworzyć kanał RSS?

1. Wejdź w wybraną przez Ciebie kategorię na stronie OLX.pl i ustaw parametry wyszukiwania.<br/>Ustaw sortowanie ogłoszeń po najnowszych, żeby śledzić najnowsze ogłoszenia w kanale RSS. W kanale RSS domyślnie wyświetlane są ogłoszenia z dwóch pierwszych podstron z wynikami. 

![podgląd](https://raw.githubusercontent.com/MK-PL/OLX-RSS/master/img/img1.png)

2. Przekopiuj link URL z pola adresu WWW przeglądarki. Powinny być w nim zamieszczone parametry wyszukiwania.

![podgląd](https://raw.githubusercontent.com/MK-PL/OLX-RSS/master/img/img2.png)

3. Wprowadź adres do wskazanego pola na stronie internetowej skryptu i naciśnij przycisk "Generuj".

![podgląd](https://raw.githubusercontent.com/MK-PL/OLX-RSS/master/img/img3.png)

4. Zostanie wygenerowany kanał RSS z ogłoszeniami o podanych parametrach wyszukiwaniach, jak w podanym adresie URL do serwisu OLX.pl.

![podgląd](https://raw.githubusercontent.com/MK-PL/OLX-RSS/master/img/img4.png)

## Co zostało użyte do zrobienia OLX RSS?

- HTML/CSS/PHP
- FeedWriter (https://github.com/mibe/FeedWriter)
- PHP Simple HTML DOM Parser (http://simplehtmldom.sourceforge.net)

## Zmiany

- 0.1.0 Start skryptu.

## Błędy

Wykryte błędy proszę zgłaszać w sekcji 'Issues' projektu - dzięki temu inni użytkownicy będą mogli zapoznać się z problemem (zwłaszcza, jeśli mają podobny) i ewentualnie zaproponować swoje rozwiązania.

## Autor

Maciej Kawa

kontakt [at] maciejkawa.lubin.pl

Chcesz wesprzeć moją pracę? Możesz pozostawić symboliczną dotację na [PayPalu](https://www.paypal.me/MaciejKawa).