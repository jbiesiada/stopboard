# stopboard

an app to search for nearest bus/tram leave from selected bus/tram stop in Kraków

when it runs first time in a day it downloads fresh  data from Kraków mpk web page




zadanie:
Proszę o stworzenie aplikacji pozwalającej na zobaczenia tablicy najbliższych odjazdów z danego przystanku MPK/ZTM z wybranego miasta w Polsce 
Po lewej mamy liste mozliwych przystankow z wyszukiwarka - po wybraniu konkretnego, po prawej stronie pojawia sie nazwa wybranego przystanku, aktualna godzina oraz 5 najbliższych odjazdów (w formacie Linia | Kierunek | 5 min).
Rozkład powinien uwzględniać dni powszednie, soboty i niedziele (bez dni świątecznych które są w tygodniu)
Z wybranego miasta - np. Krakowa - ze strony MPK (http:/rozklady.mpk.krakow.pl) proszę programowo ściągnąć listę przystanków i rozkład wszystkich linii z tego przystanku (dane cachujemy do bazy na 24h) 
Strona zewnętrzna powinna być zrobiona przy pomocy AngularJS
Framework do wyboru: Symfony2, Laravel . Najlepiej bez używania bezpośrednio curl'a, tylko biblioteki (np.Goutte)
Baza do wyboru MySQL/MongoDB

Projekt wysyłamy na bieżąco na prywatnego GitHuba
Proszę o komentarz z wyceną przed rozpoczęciem projektu.