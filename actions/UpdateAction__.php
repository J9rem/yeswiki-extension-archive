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

class UpdateAction__ extends YesWikiAction
{
    protected $archiveService;
    protected $securityController;

    public function formatArguments($arg)
    {
        return([
            'internalArg_makeBackup' => $this->formatBoolean($arg, false, 'internalArg_makeBackup'),
            'internalArg_upgrade' => (isset($arg['internalArg_upgrade']) && is_string($arg['internalArg_upgrade'])) ? $arg['internalArg_upgrade'] : "",
        ]);
    }

    public function run()
    {
        $this->archiveService = $this->getService(ArchiveService::class);
        $this->securityController = $this->getService(SecurityController::class);

        if (!$this->securityController->isWikiHibernated() &&
            $this->wiki->UserIsAdmin() &&
            $this->arguments['internalArg_makeBackup']
        ) {
            $this->output = $this->render("@archive/preupdate-backup.twig", [
                'upgrade' => $this->arguments['internalArg_upgrade']
            ]);
            return "";
        }
        return "";
    }
}
