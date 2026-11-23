# Studio Spikkel

Een Nederlandse cadeauwinkel gebouwd met CakePHP 5 en MySQL. Het projectplan staat in [PLAN.md](PLAN.md).

## Lokaal starten

```powershell
.\start-spikkel.bat
```

Open [Studio Spikkel](http://localhost:8766) en laat het terminalvenster open. Met Ctrl+C stop je de webserver.

De launcher gebruikt de MySQL-server die al op deze pc staat. Studio Spikkel heeft een eigen schema `studio_spikkel` en eigen gebruiker `spikkel_app`. De lokale inloggegevens staan in het genegeerde `config/app_local.php`. MySQL kan blijven draaien voor andere lokale projecten als je de webserver afsluit.

Gebruik `composer install` als `vendor` ontbreekt. Kopieer op een andere machine `config/app_local.example.php` naar `config/app_local.php` en vul daar je eigen databaseverbinding in. Voer bij een nieuwe database eerst de migraties hieronder uit.

## Collectie en nieuws laden

```powershell
.\bin\cake.bat migrations migrate
.\bin\cake.bat schema_cache clear products
.\bin\cake.bat seeds run ShopDemo
.\bin\cake.bat seeds run GiftCardsCatalog
```

De seeds voegen vier fysieke cadeaus, drie bedragen voor de digitale cadeaubon en het nieuwsbericht toe. Een volgende uitvoering laat bestaande gegevens staan.

## Formulieren

Inzendingen komen lokaal in `contact_messages` en `collaboration_requests`. Er gaat geen mail naar buiten. Bijlagen staan onder een willekeurige bestandsnaam in `storage/uploads/collaborations`, buiten `webroot` en Git. Beheerders kunnen aanvragen en bijlagen openen in Winkelbeheer. Houd de map schrijfbaar voor PHP. Gebruik op een andere PHP-server een uploadlimiet van minstens 5 MB en een limiet voor POST-gegevens van minstens 8 MB.

## Account en winkelmand

Een bezoeker kan vanaf een productpagina een cadeau toevoegen. Het mandje bewaart product-ID's en aantallen in de Studio Spikkel-sessie. Prijzen komen uit de catalogus. Registreren en inloggen gebruiken een eigen account in MySQL. Inloggen vanuit het mandje brengt je terug naar afrekenen, ook als je eerst registreert.

## Demo-bestelling plaatsen

Kies verzenden of afhalen, eventueel met cadeauverpakking en een kaartje. Controleer het overzicht en plaats de demo-bestelling. De bevestiging en **Mijn bestellingen** tonen dezelfde opgeslagen bedragen. Adresgegevens worden alleen bij verzending opgeslagen. Het bedrag van een digitale cadeaubon telt niet mee voor de gratis verzenddrempel. Bij een digitale bon staat de demo-code in de bestelling. Er wordt niets afgeschreven, verstuurd of gemaild en er is geen betaalprovider aangesloten.

## Winkelbeheer

Maak eerst een account aan via de winkel. Geef dat account lokaal beheerrechten vanuit de projectmap. Gebruik het e-mailadres waarmee je het account hebt gemaakt.

~~~powershell
.\bin\cake.bat beheer grant jouw@email.nl
~~~

Open [Winkelbeheer](http://localhost:8766/beheer) of kies **Naar beheer** bij **Mijn account**. Met de opdracht hierboven en 'revoke' in plaats van 'grant' trek je beheerrechten meteen in.

- Zet **Tonen in de winkel** uit om een product te verbergen. De bestaande bestellingen houden hun oorspronkelijke prijs en productnaam. De waarde van een digitale cadeaubon ligt vast.
- Bewaar nieuws met een lege publicatiedatum als concept of plan het voor een latere datum. De editors gebruiken de huidige beeldbibliotheek.
- Bekijk demo-orders, contactberichten en samenwerkingsaanvragen in het menu. Een bijlage bij een aanvraag download je vanuit het detail. De bestanden staan buiten de publieke webmap.

## Vakantiemelding bekijken buiten augustus

Start desgewenst een tweede lokale preview op een vrije poort zodat de gewone site kan blijven draaien.

```powershell
$env:STORE_CLOSURE_PREVIEW = '1'
php .\bin\cake.php server -H 127.0.0.1 -p 8767
# Verwijder de variabele na het stoppen van de preview.
Remove-Item Env:STORE_CLOSURE_PREVIEW
```

Open [de vakantiepreview](http://localhost:8767). Het gewone datumbereik en de openingstijden staan in `config/store.php`.

`composer check` draait de tests en codestijlcontrole. De tests gebruiken hun eigen SQLite-verbinding.
