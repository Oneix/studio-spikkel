<?php
declare(strict_types=1);

namespace App\Store;

final class CatalogImages
{
    /**
     * Use only the published image library in these editors.
     */
    public static function options(): array
    {
        return [
            'collectie/notitieboekje.webp' => 'Notitieboekje met bloemenprint',
            'collectie/geurkaars.webp' => 'Geurkaars in blik',
            'collectie/muurposter.webp' => 'Muurposter met quote',
            'collectie/oorbellen.webp' => 'Handgemaakte oorbellen',
            'collectie/cadeaubon.webp' => 'Digitale cadeaubon',
            'winkel/atelier.webp' => 'De winkel',
            'winkel/team.webp' => 'Emma en Noor',
            'spikkel-cover.webp' => 'Omslag Studio Spikkel',
        ];
    }
}
