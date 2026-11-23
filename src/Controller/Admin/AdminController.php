<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Store\CatalogImages;
use Cake\Database\Exception\QueryException;
use Cake\Datasource\EntityInterface;
use Cake\Http\Response;
use Cake\ORM\Table;

abstract class AdminController extends AppController
{
    /**
     * Give all admin pages the same navigation and layout.
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('admin');
    }

    /**
     * Save the allowed fields and show the editor again when validation fails.
     */
    protected function saveContent(
        Table $table,
        EntityInterface $form,
        array $data,
        array $fields,
        string $route,
    ): ?Response {
        $table->patchEntity($form, $data, ['fields' => $fields, 'associated' => [], 'validate' => 'admin']);
        try {
            if ($table->save($form)) {
                $this->Flash->success('Opgeslagen.');

                return $this->redirect(['_name' => $route], 303);
            }
        } catch (QueryException $exception) {
            $conditions = ['slug' => $form->get('slug')];
            if (!$form->isNew()) {
                $conditions['id !='] = $form->get('id');
            }
            if ((string)$exception->getPrevious()?->getCode() !== '23000' || !$table->exists($conditions)) {
                throw $exception;
            }
            $form->setError('slug', ['Deze URL-naam is al in gebruik.']);
        }
        $this->response = $this->response->withStatus(422);

        return null;
    }

    /**
     * Prepare the editor and the existing shop images.
     */
    protected function showEditor(EntityInterface $form, array $extra = []): void
    {
        $this->set($extra + ['form' => $form, 'images' => CatalogImages::options()]);
        $this->viewBuilder()->setTemplate('form');
    }

    /**
     * Trim text from the editor while leaving validation to its table.
     */
    protected function postedContent(): array
    {
        return array_map(
            static fn(mixed $value): mixed => is_string($value) ? trim($value) : $value,
            $this->request->getData(),
        );
    }
}
