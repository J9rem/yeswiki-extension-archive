<?php
/*
 * This file is part of the YesWiki Extension archive.
 *
 * Authors : see README.md file that was distributed with this source code.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace YesWiki\Archive\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use YesWiki\Archive\Service\ArchiveService;
use YesWiki\Wiki;

class ArchiveCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'archive:archive';

    protected $archiveService;
    protected $wiki;

    public function __construct(Wiki &$wiki)
    {
        parent::__construct();
        $this->archiveService = $wiki->services->get(ArchiveService::class);
        $this->wiki = $wiki;
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Create archive of the YesWiki.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("Create archive of the YesWiki.\n".
                "To not save files use '--nosavefiles'\n".
                "To not save database use '--nosavedatabase'\n")
            
            ->addOption('nosavefiles', 'd', InputOption::VALUE_NONE, 'Do not save files of the wiki')
            ->addOption('nosavedatabase', 'f', InputOption::VALUE_NONE, 'Do not save database')
            ->addOption('extrafiles', 'e', InputOption::VALUE_REQUIRED, 'Extrafiles, path relative to root, coma separated')
            ->addOption('excludedfiles', 'x', InputOption::VALUE_REQUIRED, 'Excludedfiles, path relative to root, coma separated')
            ->addOption('hideConfigValues', 'a', InputOption::VALUE_REQUIRED, 'Params to anonymize in wakka.config.php, json_encoded')
            ->addOption('uid', 'u', InputOption::VALUE_REQUIRED, 'uid to retrive input and ouput files')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $nosavefiles = $input->getOption('nosavefiles');
        $nosavedatabase = $input->getOption('nosavedatabase');

        if ($nosavefiles && $nosavedatabase) {
            $output->writeln("Invalid options : It is not possible to use --nosavefiles and --nosavedatabase options in same time.");
            return Command::INVALID;
        }

        $extrafiles = $this->prepareFileList($input->getOption('extrafiles'));
        $excludedfiles = $this->prepareFileList($input->getOption('excludedfiles'));
        $rawHideConfigValues = $input->getOption('hideConfigValues');
        $anonymous = null;
        if (!empty($rawHideConfigValues)) {
            $rawHideConfigValues = json_decode($rawHideConfigValues, true);
            if (is_array($rawHideConfigValues)) {
                $anonymous = $rawHideConfigValues;
            }
        }
        $uid = $input->getOption('uid');
        $uid = empty($uid) ? "" : $uid;

        $location = $this->archiveService->archive($output, !$nosavefiles, !$nosavedatabase, $extrafiles, $excludedfiles, $anonymous, $uid);

        return Command::SUCCESS;
    }

    private function prepareFileList($list): array
    {
        if (empty($list)) {
            $list = [];
        } else {
            $list = array_filter(array_map('trim', explode(',', $list)));
        }
        return $list;
    }
}
