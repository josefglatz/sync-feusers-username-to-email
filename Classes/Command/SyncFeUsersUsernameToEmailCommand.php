<?php

declare(strict_types=1);

namespace JosefGlatz\SyncFeUsersUsernameToEmail\Command;

use Doctrine\DBAL\Exception;
use JosefGlatz\SyncFeUsersUsernameToEmail\Service\SyncColumnsService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SyncFeUsersUsernameToEmailCommand extends Command
{
    private SyncColumnsService $syncColumnsService;

    public function __construct(
        SyncColumnsService $syncColumnsService
    )
    {
        $this->syncColumnsService = $syncColumnsService;
        parent::__construct('fe_users:sync-username-to-email');
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Sync the username to email field in the fe_users table')
            ->setHelp('This command allows you to sync the username with the email field for all users in the fe_users table.');
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $syncResult = $this->syncColumnsService->updateAllRecords(
            'fe_users',
            'username',
            'email'
        );
        if ($syncResult === 0) {
            $output->writeln(sprintf('No records in the fe_users table were updated. (The query result returned "%s")', $syncResult));
        } elseif ($syncResult === 1) {
            $output->writeln(sprintf('The username has been synced with the email column for %s record in the fe_users table.', $syncResult));
        } else {
            $output->writeln(sprintf('The username has been synced with the email column for %s records in the fe_users table.', $syncResult));
        }

        return Command::SUCCESS;
    }
}
