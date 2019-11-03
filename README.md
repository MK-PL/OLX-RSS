# OLX RSS
OLX RSS jest generatorem kanału RSS do serwisu OLX.pl, który pozwala na spersonalizowanie wszystkich parametrów wyszukiwania.

## Jak zainstalować?

Skopiuj pliki na serwer obsługujący PHP w wersji >= 5.3 i otwórz w przeglądarce adres http://ADRES_SERWERA/index.html

## Jak stworzyć kanał RSS?

1. Wejdź w wybraną przez Ciebie kategorię na stronie OLX.pl i ustaw parametry wyszukiwania.<br/>Ustaw sortowanie ogłoszeń po najnowszych, żeby śledzić najnowsze ogłoszenia w kanale RSS. W kanale RSS domyślnie wyświetlane są ogłoszenia z dwóch pierwszych podstron z wynikami. 

![podgląd](https://raw.githubusercontent.com/MK-PL/OLX-RSS/master/img/img1.png)

---

2. Przekopiuj link URL z pola adresu WWW przeglądarki. Powinny być w nim zamieszczone parametry wyszukiwania.

![podgląd](https://raw.githubusercontent.com/MK-PL/OLX-RSS/master/img/img2.png)

Uwaga! Portal OLX.pl może wyświetlić inne wyniki wyszukiwania, jeżeli podana fraza jest podobna do innej, popularniejszej frazy. Wówczas należy kliknąć na link w komunikacie 'Zamiast tego wyszukaj <fraza>' i skopiować nowy link URL z pola adresu WWW przeglądarki (taki link URL powinien zawierać w końcówce fragment '?spellchecker=off').

---

3. Wprowadź adres do wskazanego pola na stronie internetowej skryptu i naciśnij przycisk "Generuj".

![podgląd](https://raw.githubusercontent.com/MK-PL/OLX-RSS/master/img/img3.png)

---

4. Zostanie wygenerowany kanał RSS z ogłoszeniami o podanych parametrach wyszukiwaniach, jak w podanym adresie URL do serwisu OLX.pl.

![podgląd](https://raw.githubusercontent.com/MK-PL/OLX-RSS/master/img/img4.png)

## Co zostało użyte do zrobienia OLX RSS?

- HTML/CSS/PHP
- Bhaktaraz RSSGenerator (https://github.com/bhaktaraz/php-rss-generator)
- PHP Simple HTML DOM Parser (http://simplehtmldom.sourceforge.net)

## Zmiany

- 0.1.4 Wykluczenie losowych ofert, gdy brak wyników wyszukiwania
- 0.1.3 Naprawienie działania generatora kanałów na serwerze PHP w wersji 7.3, naprawienie błędu uniemożliwiającego wyszukiwanie ofert zawierających polskie znaki
- 0.1.2 Naprawienie błędu powtarzających się ofert w kanale RSS, zmiana generatora kanałów RSS.
- 0.1.1 Naprawienie wyświetlania ofert promowanych (wyróżnionych) w kanale RSS.
- 0.1.0 Start skryptu.

## Błędy

Wykryte błędy proszę zgłaszać w sekcji 'Issues' projektu - dzięki temu inni użytkownicy będą mogli zapoznać się z problemem (zwłaszcza, jeśli mają podobny) i ewentualnie zaproponować swoje rozwiązania.

## Autor

Maciej Kawa

kontakt [at] maciejkawa.lubin.pl

Chcesz wesprzeć moją pracę? Możesz pozostawić symboliczną dotację na [PayPalu](https://www.paypal.me/MaciejKawa).