<?php
declare(strict_types=1);

use Cake\I18n\Date;
use Cake\ORM\Entity;
use Cake\ORM\Locator\TableLocator;
use Migrations\BaseSeed;

class ShopDemoSeed extends BaseSeed
{
    public function isIdempotent(): bool
    {
        return true;
    }

    public function run(): void
    {
        $tables = new TableLocator();
        $connection = $this->getAdapter()->getConnection();
        $products = $tables->get('Products', ['connection' => $connection]);
        foreach ([
            [
                'slug' => 'notitieboekje-met-bloemenprint',
                'name' => 'Notitieboekje met bloemenprint',
                'category' => 'Papierwaren',
                'summary' => 'Een linnen boekje met veldbloemen voor lijstjes, plannen en losse gedachten.',
                'description' => 'Een boekje dat je graag openlaat op tafel. Op de stoffen omslag staan kleine veldbloemen in lila en roestbruin. Binnenin is plek voor boodschappen, schetsjes of dat ene idee dat je morgen nog wilt weten. Met het paarse lint vind je je bladzijde terug.',
                'price_cents' => 1295,
                'image' => 'collectie/notitieboekje.webp',
                'image_alt' => 'Crèmekleurig linnen notitieboekje met veldbloemen en een paars leeslint.',
                'position' => 10,
            ],
            [
                'slug' => 'geurkaars-in-blik',
                'name' => 'Geurkaars in blik',
                'category' => 'Kaarsen',
                'summary' => 'Een handgegoten kaars met zachte vanille in een blikje dat je kunt hergebruiken.',
                'description' => 'Steek de kaars aan als de dag erop zit. De zachte vanillegeur is warm en licht. Is de kaars op, dan krijgt het blikje makkelijk een tweede leven voor knopen, sieraden of andere kleine dingen.',
                'price_cents' => 1450,
                'image' => 'collectie/geurkaars.webp',
                'image_alt' => 'Brandende geurkaars in een rond messingkleurig blik met het deksel ernaast.',
                'position' => 20,
            ],
            [
                'slug' => 'muurposter-met-quote',
                'name' => 'Muurposter met quote',
                'category' => 'Posters',
                'summary' => 'Een A4-print op crèmekleurig papier met een kleine oppepper voor aan de muur.',
                'description' => 'Kleine dingen doen ertoe. Die vier woorden staan op deze A4-poster, samen met een paar getekende bloemetjes. Hang hem bij je bureau of geef hem aan iemand die wel een oppepper kan gebruiken. De poster komt zonder lijst.',
                'price_cents' => 1195,
                'image' => 'collectie/muurposter.webp',
                'image_alt' => 'Crèmekleurige poster met paarse bloemen en de tekst Kleine dingen doen ertoe.',
                'position' => 30,
            ],
            [
                'slug' => 'handgemaakte-oorbellen',
                'name' => 'Handgemaakte oorbellen',
                'category' => 'Sieraden',
                'summary' => 'Kleine goudkleurige ringetjes met een bloem aan elk oor.',
                'description' => 'Twee fijne ringetjes met handgemaakte bloembedels. De bedels bewegen mee als je loopt en geven net wat glans. Een klein cadeautje voor iemand die graag bloemen draagt, ook op een gewone dinsdag.',
                'price_cents' => 1995,
                'image' => 'collectie/oorbellen.webp',
                'image_alt' => 'Twee goudkleurige oorbellen met bloembedels op een terracotta schaaltje.',
                'position' => 40,
            ],
        ] as $item) {
            $products->findOrCreate(['slug' => $item['slug']], static function (Entity $record) use ($item): void {
                $record->patch($item + ['active' => true]);
            });
        }

        $news = $tables->get('NewsPosts', ['connection' => $connection]);
        $news->findOrCreate(['slug' => 'onze-nieuwe-collectie-is-binnen'], static function (Entity $record): void {
            $record->patch([
                'title' => 'Onze nieuwe collectie is binnen!',
                'summary' => 'Geurkaarsen in blik en boekjes met veldbloemen. De eerste cadeaus uit de nieuwe collectie liggen in de winkel.',
                'body' => "We hebben de afgelopen dagen uitgepakt en de tafel opnieuw ingericht. Daar staan nu handgegoten geurkaarsen in blik, naast notitieboekjes met veldbloemen op de omslag. De kaarsjes hebben een zachte vanillegeur. De boekjes hebben een leeslint, handig als je ze voor meer dan één lijstje gebruikt.\n\nEr hangen ook nieuwe posters in de winkel en er zijn kleine bloemoorringetjes bij gekomen. Loop gerust eens binnen of bekijk de cadeaus online.",
                'image' => 'collectie/geurkaars.webp',
                'image_alt' => 'Een brandende geurkaars uit de nieuwe collectie van Studio Spikkel.',
                'published_on' => new Date('2020-03-13'),
            ]);
        });
    }
}
