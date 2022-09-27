<?php

/*
 * This file is part of the YesWiki Extension archive.
 *
 * Authors : see README.md file that was distributed with this source code.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace YesWiki\Archive;

use YesWiki\Archive\Service\ArchiveService;
use YesWiki\Core\YesWikiAction;
use YesWiki\Security\Controller\SecurityController;

class __UpdateAction extends YesWikiAction
{
    protected $archiveService;
    protected $securityController;

    public function formatArguments($arg)
    {
        return([
            'internalArg_makeBackup' => false,
        ]);
    }

    public function run()
    {
        $this->archiveService = $this->getService(ArchiveService::class);
        $this->securityController = $this->getService(SecurityController::class);

        if (
            $this->wiki->UserIsAdmin() &&
            isset($_GET['upgrade']) &&
            !$this->archiveService->hasValidatedBackup($_GET['forcedUpdateToken'] ?? "") &&
            !$this->securityController->isWikiHibernated()
        ) {
            $upgrade = $_GET['upgrade'];
            unset($_GET['upgrade']);

            // set random version to be sure not update something

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < 10; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $randomString .= $characters[$index];
            }
            $this->arguments['version'] = "unknown_$randomString";
            $this->arguments['internalArg_makeBackup'] = true;
            $this->arguments['internalArg_upgrade'] = $upgrade;
        }
        return "";
    }
}
