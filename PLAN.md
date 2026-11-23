# Studio Spikkel — bouwplan

Deel 1 t/m 6 zijn afgerond. De winkel heeft een demo-checkout en een eigen beheeromgeving.

Studio Spikkel wordt een Nederlandstalige cadeauwinkel waar je producten ontdekt, nieuws leest, het team leert kennen en een demo-bestelling kunt plaatsen. Ik zet een nieuwe CakePHP-app op met Composer, MySQL, eigen templates en CSS. De CMS-tutorial blijft een los project. De inhoud uit de inwerkcasus neem ik over waar die vastligt. Dingen die in de sitebuilder een module waren, krijgen hier hun eigen plek in de app.

Voor de demo kies je een cadeau, doe je het in je mandje, log je in en kies je tussen bezorgen of afhalen. De laatste knop heet **Plaats demo-bestelling**. Daarna vind je je order terug onder **Mijn bestellingen**. Vanaf de winkelmand is duidelijk dat er geen afschrijving of echte levering volgt. Ik vraag geen kaart- of bankgegevens en sluit geen betaalprovider, verkoop-API of verzenddienst aan.

## 1. Project en huisstijl

**User story.** Als bezoeker wil ik meteen zien wat voor winkel Studio Spikkel is en op mijn telefoon makkelijk door de site kunnen gaan.

- [x] Nieuwe CakePHP-app aanmaken in de map `studio-spikkel`. Git starten, een eigen database `studio_spikkel` met eigen databasegebruiker instellen en uitleggen hoe ik het project lokaal start. Lokale wachtwoorden en uploads blijven buiten Git.
- [x] Eén gedeelde layout maken met Home, Over Studio Spikkel, Cadeaus, Nieuws, Team en Contact in het hoofdmenu. Veelgestelde vragen in de footer. Winkelmand en account als vaste links in de header.
- [x] Eigen logo en favicon maken. Home krijgt een omslagfoto, een korte Nederlandse headline en knoppen naar Cadeaus en de samenwerkingspagina. Het formulier zelf hoort bij deel 3. De homepage heeft één coverfoto en korte links naar Cadeaus, Over de winkel en Nieuws. De productkaarten horen bij deel 2.
- [x] Zacht lila `#CBAACB`, zand `#EFD9CE`, zacht mint `#BFD8B8` en donker taupe `#3E3E3E` gebruiken. Quicksand voor koppen en accenten, Open Sans voor lopende tekst. De cover heeft alt-tekst en beide lettertypes staan lokaal in de app.
- [x] De [Facebook-link](https://www.facebook.com/MKBMarketingTeam) en [Instagram-link](https://www.instagram.com/mkbmarketingteam/) uit de brief in de footer zetten.

**Klaar als** de nieuwe app lokaal start, de zes hoofdpagina's bereikbaar zijn en ik het menu op mobiel en met alleen het toetsenbord kan gebruiken.

**Afgerond.** De nieuwe app draait op poort 8766 met een eigen MySQL-schema en databasegebruiker. Alle pagina's openen. Menu en links zijn gecontroleerd op desktop en mobiel, ook met het toetsenbord en zonder JavaScript. `composer check` is geslaagd.

## 2. Producten, winkelinformatie en nieuws

**User stories.** Als klant wil ik per cadeau een foto, prijs en omschrijving zien. Als bezoeker wil ik weten wie er in de winkel staat, wanneer ik langs kan en wat er nieuw is.

- [x] Producten in MySQL zetten via een migratie en demodata. Cadeaus krijgt een overzicht en een detailpagina per product. Start met **Notitieboekje met bloemenprint**, **Geurkaars in blik**, **Muurposter met quote** en **Handgemaakte oorbellen**. Elk product krijgt een passende foto, een korte omschrijving en een prijs in euro's. Demoprijzen zijn €12,95 voor het notitieboekje, €14,50 voor de geurkaars, €11,95 voor de poster en €19,95 voor de oorbellen. Ze staan in de seed en als centen in MySQL.
- [x] De aangeleverde tekst op Over Studio Spikkel plaatsen. **Over de eigenaar** krijgt een kop in een huisstijlkleur met voldoende contrast. Onderaan komen een foto en de knop **Neem contact op** naar Contact.
- [x] Team als aparte pagina maken met **Emma — eigenaresse & ontwerpster** en **Noor — winkelmedewerker & social media**. Teamleden staan los van de productcatalogus.
- [x] Nieuwsoverzicht en artikelpagina maken. Het eerste bericht heet **Onze nieuwe collectie is binnen!**, met een kort stuk over de nieuwe kaarsen en notitieboekjes. Publicatiedatum `13-03-2020`.
- [x] Op Contact komen het e-mailadres `hallo@studiospikkel.nl`, de openingstijden en een link naar Samenwerken. Het contactformulier staat in deel 3. Ma t/m do 09.00–17.00, vr 09.00–21.00, za 10.00–18.00, zo gesloten. Voor **3 t/m 18 augustus** komt er een sluitingsmelding én een pop-up die je kunt wegklikken. Ik maak het datumbereik instelbaar, met een manier om de melding lokaal te demonstreren.

**Klaar als** ik de producten kan openen, het nieuwsbericht met de juiste datum zie en de zomermelding kan testen zonder de systeemdatum te wijzigen.

**Afgerond.** Vier cadeaus en het nieuwsbericht staan in MySQL. De pagina's en afbeeldingen zijn gecontroleerd op mobiel en desktop. De openingstijden staan bij Contact. De vakantiemelding is getest op de eerste en laatste dag en in een lokale preview. De test- en codestijlcontrole is geslaagd.

## 3. Contact, samenwerking en FAQ

**User stories.** Als bezoeker wil ik een vraag kunnen sturen of zelf een antwoord vinden. Als maker wil ik kunnen voorstellen om mijn product via Studio Spikkel te verkopen.

- [x] Een contactformulier maken met naam, e-mail en bericht. De inzending in de app bewaren en na een geslaagde inzending een bevestiging tonen.
- [x] Vanaf Home naar **Samenwerking aanvragen** linken. Het formulier vraagt om naam, e-mail, website of portfoliolink, omschrijving van product of idee, categorie (Wenskaarten / Kaarsen / Posters / Sieraden / Anders), huidige verkoopkanalen, keuze om op de hoogte te blijven, voorkeursdatum voor contact en een productfoto of voorstel als bijlage. Naam, e-mail, omschrijving en categorie worden verplicht. De andere velden zijn optioneel en de keuze voor updates staat standaard uit.
- [x] De informatiebalk uit de brief bij het formulier plaatsen. “We streven ernaar om binnen 5 werkdagen contact met je op te nemen. Je gegevens worden vertrouwelijk behandeld.” Foto's en voorstellen controleren op bestandstype en grootte (JPG, PNG of PDF, maximaal 5 MB), opslaan buiten de publieke map voor het beheergedeelte in deel 6. Er is geen publieke downloadlink.
- [x] FAQ maken met een ankerlink per vraag over levertijden, retourneren, contact, digitale cadeaubonnen, cadeauverpakking met persoonlijk bericht en samenwerken. De verzendtabel leest de bedragen en drempels uit `config/store.php`. In deel 5 gebruikt afrekenen dezelfde gegevens. Bij retourneren staat de termijn van 14 dagen en het verzoek om het ordernummer te mailen. Vanuit de antwoorden linken naar Contact, Cadeaus of het samenwerkingsformulier waar dat helpt.

**Klaar als** beide formulieren valide gegevens bewaren, fouten bij de juiste velden staan, een verkeerd bestand wordt geweigerd en elke FAQ-link naar het juiste antwoord springt.

**Afgerond.** Beide formulieren slaan inzendingen op in MySQL en tonen een bevestiging. Ik heb geldige en ongeldige inzendingen getest, inclusief een PDF boven 2 MB, een verkeerd bestandstype en de grens van 5 MB. De zes FAQ-links springen naar hun eigen antwoord. Inzendingen worden lokaal opgeslagen zonder e-mail te versturen. Beheer volgt in deel 6.

## 4. Account en winkelmand

**User story.** Als klant wil ik zonder account kunnen rondkijken en mijn mandje vullen, en na het inloggen verdergaan waar ik was.

- [x] Registreren, inloggen en uitloggen maken met CakePHP Authentication. E-mailadressen uniek houden en wachtwoorden hashen. Afrekenen vereist een ingelogd account. De controle op eigendom van orders hoort bij deel 5.
- [x] Mandje in de sessie bijhouden. Toevoegen vanaf een productpagina, aantallen aanpassen, verwijderen en subtotaal tonen. Een leeg mandje geeft een link terug naar Cadeaus. Ongeldige aantallen worden geweigerd.
- [x] Bij **Naar afrekenen** eerst laten inloggen of registreren als dat nodig is. Het mandje blijft behouden. Na inloggen gaat de klant verder met afrekenen, ook als er eerst een account is aangemaakt.

**Klaar als** een gast twee cadeaus in het mandje kan doen, een account kan maken en na inloggen beide artikelen terugziet bij de checkout.

**Afgerond.** Een gast kan cadeaus toevoegen, aantallen aanpassen en cadeaus verwijderen. Ik heb registratie en inloggen vanuit het mandje doorlopen en zag dezelfde twee cadeaus bij afrekenen. Prijzen komen uit MySQL. Studio Spikkel gebruikt eigen cookies.

## 5. Demo-checkout en Mijn bestellingen

**User story.** Als ingelogde klant wil ik zien wat mijn bestelling zou kosten, hem kunnen plaatsen en later precies kunnen terugzien wat ik heb besteld.

- [x] Checkout maken met keuze tussen verzenden en afhalen. Verzendadres alleen verplicht bij verzending van fysieke artikelen. Voeg **Als cadeau inpakken** en een optioneel persoonlijk bericht toe. Een bestelling met alleen een digitale bon heeft geen verzendkosten.
- [x] Een digitale cadeaubon vanaf €10 bestelbaar maken als demo-artikel, zoals de FAQ belooft. Het gekozen bedrag staat in het mandje en in de bestelling. De bon vertegenwoordigt geen echt tegoed.
- [x] Verzendkosten in één CakePHP-service berekenen. Dezelfde regels gebruiken voor de FAQ, het besteloverzicht en de definitieve bevestiging. Bedragen rekenen in centen. De gratis drempel geldt voor het subtotaal van fysieke producten.

| Bestemming | Levertijd uit de casus | Kosten | Gratis vanaf |
| --- | --- | ---: | ---: |
| Nederland | 1–2 werkdagen | € 3,95 | € 40,00 |
| België | 2–4 werkdagen | € 6,95 | € 60,00 |
| Duitsland | 2–5 werkdagen | € 7,95 | € 70,00 |
| Afhalen | Direct beschikbaar | Gratis | n.v.t. |

- [x] Op Home of bij Cadeaus een actie tonen voor gratis verzending. De brief zegt bij de promo “boven €40” en bij de FAQ “vanaf €40”. Ik volg de FAQ en gebruik **Gratis verzending binnen Nederland vanaf €40**. Bij €39,99 kost verzending €3,95 en bij €40,00 is die gratis. Voor België en Duitsland gelden de eigen drempels.
- [x] Een overzicht tonen vóór het plaatsen. Producten, bedragen en verzending opnieuw op de server controleren. Bij gewijzigde prijzen of onbeschikbare producten eerst het bijgewerkte overzicht tonen. Eén klik of dubbele verzending van hetzelfde verzoek levert één order op.
- [x] Order en orderregels in één databasetransactie opslaan. Artikelnaam, prijs, aantal, bezorgkeuze, adres indien nodig, cadeauopties en totalen vastleggen zoals ze op dat moment waren. Het mandje pas legen nadat het opslaan is gelukt.
- [x] Bevestiging tonen met **Bestelling geplaatst**, ordernummer, bestelregels en totaal. **Mijn bestellingen** krijgt een overzicht en detailpagina. Klanten kunnen alleen hun eigen orders openen, ook als ze een ander ordernummer in de URL proberen.

**Klaar als** een aankoop eindigt met één opgeslagen demo-order, dezelfde bedragen op de bevestiging en in het account staan, en de foutpaden (leeg mandje, geen login, dubbel klikken, andere eigenaar) zijn getest.

**Afgerond.** Verzenden, afhalen en een bestelling met alleen digitale bonnen zijn doorlopen. De cadeaubon is er voor €10, €25 en €50. Elke bon krijgt in de order een eigen democode zonder tegoed. Cadeauverpakking is gratis. Ik heb getest dat een nieuwe prijs om een tweede bevestiging vraagt en dat dubbel inzenden één order oplevert. Met twee accounts heb ik gecontroleerd dat je alleen je eigen bestellingen kunt openen. In Mijn bestellingen staan dezelfde bedragen als op de bevestiging.

## 6. Beheer, laatste controle en demo

**User story.** Als winkelbeheerder wil ik producten en nieuws kunnen bijwerken en binnengekomen vragen en demo-orders kunnen bekijken.

- [x] Een klein beheergedeelte achter een beheerdersrol maken. Producten en nieuws aanpassen, demo-orders bekijken en contact- en samenwerkingsinzendingen met bijlagen openen. Een product uit het assortiment halen zonder eerdere orders te wijzigen.
- [x] Normale klantaccounts en beheerders apart testen. Bij formulieren servervalidatie en CSRF-bescherming gebruiken. Controleren dat inzendingen, adressen en foto's niet via publieke pagina's of uploads bereikbaar zijn.
- [x] De site nalopen op een smal scherm en desktop. Menu, focus, contrast, formulierlabels, verzendtabel en pop-up met toetsenbord testen. Lege staten en foutmeldingen kort en duidelijk houden.
- [x] Met een nieuwe database de installatie en demodata doorlopen. Tests richten op het bestelpad, prijzen en drempels, dubbele orders, login, klanttoegang en bestandsuploads. Daarna de volledige demo nog een keer in de browser doorlopen.

**Afgerond deel 6.** Deel 6 is getest. Ik heb een product aangepast en uit het assortiment gehaald terwijl de eerdere order gelijk bleef. Een nieuwsbericht bleef verborgen tot publicatie. Ik heb als klant en als beheerder de demo doorlopen, inclusief beide formulieren en het downloaden van de bijlage. De installatie en seeds zijn ook op een lege testdatabase gedraaid.

## Demo starten met Docker

- [x] PHP en MySQL via Docker Compose opstarten. Bij de eerste start het schema en de demodata klaarzetten. Bestellingen, accounts en uploads bewaren in volumes. De startopdracht en de beheeropdracht staan in de README.
