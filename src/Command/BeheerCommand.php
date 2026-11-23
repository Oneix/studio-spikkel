<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\ORM\TableRegistry;

class BeheerCommand extends Command
{
    /**
     * Accept an existing account and an explicit change to its admin rights.
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        return $parser->setDescription('Geef een bestaand account beheerrechten of trek deze in.')
            ->addArgument('actie', ['required' => true, 'choices' => ['grant', 'revoke']])
            ->addArgument('email', ['required' => true, 'help' => 'E-mailadres van het bestaande account']);
    }

    /**
     * Keep role changes in the local CLI.
     */
    public function execute(Arguments $args, ConsoleIo $io): int
    {
        $email = mb_strtolower(trim((string)$args->getArgument('email')));
        $users = TableRegistry::getTableLocator()->get('Users');
        $user = $users->find()->where(['email' => $email])->first();
        if ($user === null) {
            $io->error('Geen account gevonden met dit e-mailadres.');

            return static::CODE_ERROR;
        }
        $admin = $args->getArgument('actie') === 'grant';
        $user->set('is_admin', $admin);
        $users->saveOrFail($user);
        $io->success($admin ? 'Beheerrechten toegekend.' : 'Beheerrechten ingetrokken.');

        return static::CODE_SUCCESS;
    }
}
