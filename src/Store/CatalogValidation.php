<?php
declare(strict_types=1);

namespace App\Store;

use Cake\Validation\Validator;

final class CatalogValidation
{
    /**
     * Validate the URL and public image fields common to products and news.
     */
    public static function publicFields(Validator $validator): Validator
    {
        return $validator
            ->requirePresence('slug')->notEmptyString('slug', 'Vul een URL-naam in.')
            ->scalar('slug')->maxLength('slug', 140)
            ->regex('slug', '/\A[a-z0-9]+(?:-[a-z0-9]+)*\z/', 'Gebruik kleine letters, cijfers en enkele streepjes.')
            ->requirePresence('image')->notEmptyString('image', 'Kies een afbeelding.')
            ->inList('image', array_keys(CatalogImages::options()), 'Kies een afbeelding uit de lijst.')
            ->requirePresence('image_alt')->notEmptyString('image_alt', 'Beschrijf de afbeelding kort.')
            ->scalar('image_alt')->maxLength('image_alt', 220, 'Gebruik maximaal 220 tekens.');
    }
}
