Prosta gra inspirowana starymi grami przeglądarkowymi typu Plemiona.

Atkualnie działa:
-system logowania z prostą tabelą na użytkowników

-Pasek nawigacji z routingami w pełni działa relatywnie 

-Trzy tabele: użytkownicy, wioska i zasoby 

-Nick gracza odmienny od nazwy użytkownika potrzebnej do logowania, który wyświetla się po zalogowaniu

-U góry ekranu wyświetlają się pobrane z bazy surowce użytkownika

-Poniżej paska wyświetla się "budynek" z poziomem pobranym z bazy danych

Następnym krokiem będzie implementacja systemu gdzie po kliknięciu przycisku ulepszenia budynku 
rekord poziomu budynku w bazie danych zostanie zwiększony o 1, a od użytkownika odjęta zostanie odpowiednia ilość surowców, które wykorzystał na ulepszenie. 

Wtedy do pełnej funkcjonalności brakować będzie tylko pozyskiwania zasobów to jest ilość zasobów rośnie w czasie rzeczywistym zależnie od poziomu ulepszenia danego budynku to jest im wyższy poziom chaty drwala tym szybciej drewno się pozyskuje ( w przyszłości też innych czynników, przykładowo stworzenie ekwipunku gracza gdzie można ubierać przedmioty gwarantujące różne bonusy)


Kolejnym krokiem będzie wprowadzenie mechanik wojskowości. Przykładowo zbudowanie budynku "koszary" odblokuje na pasku nawigacji zakładkę "wojsko" gdzie następnie za zasoby będzie można rekturować jednostki (co będzie zapisywane w bazie danych) co pozwoli na prowadzenie ataków na dedykowane do tego zadania lochy, gdzie na podstawie formuł matematycznych będą obliczać prawdopodobieństwo powodzenia, w atakch będzie mozna zdobyć między innymi zasoby ale też wspomniany w poprzednim punkcie ekwipunek.

Następnym planem na przyszłość będzie wprowadzenie faktycznych interakcji sieciowych między graczami jak przynależność do sojuszy, system maili, czat w czasie rzeczywistym, czy też ataki na innych graczy z poza naszego sojuszu.
