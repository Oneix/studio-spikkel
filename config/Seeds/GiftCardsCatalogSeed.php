<?php
declare(strict_types=1);

use Cake\ORM\Entity;
use Cake\ORM\Locator\TableLocator;
use Migrations\BaseSeed;

class GiftCardsCatalogSeed extends BaseSeed
{
    public function isIdempotent(): bool
    {
        return true;
    }

    public function run(): void
    {
        $connection = $this->getAdapter()->getConnection();
        $products = (new TableLocator())->get('Products', ['connection' => $connection]);
        $products->setSchema($connection->getSchemaCollection()->describe('products', ['forceRefresh' => true]));
        foreach ([10, 25, 50] as $amount) {
            $products->findOrCreate(['slug' => 'cadeaubon-' . $amount], static function (Entity $product) use ($amount): void {
                $product->patch([
                    'name' => 'Digitale cadeaubon · €' . $amount,
                    'category' => 'Cadeaubon',
                    'summary' => 'Laat iemand zelf iets leuks uitzoeken.',
                    'description' => 'Je krijgt de demo-code bij je bestelling. De bon heeft geen echt tegoed.',
                    'price_cents' => $amount * 100,
                    'image' => 'collectie/cadeaubon.webp',
                    'image_alt' => 'Een crèmekleurige cadeaubon met een paarse bloem op een lila envelop.',
                    'position' => 100 + $amount,
                    'active' => true,
                    'is_digital' => true,
                ]);
            });
        }
    }
}
