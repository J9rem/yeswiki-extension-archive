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

use Exception;

use YesWiki\Core\Service\LinkTracker;
use YesWiki\Core\Service\PageManager;
use YesWiki\Core\YesWikiHandler;
use YesWiki\Security\Controller\SecurityController;

class UpdateHandler__ extends YesWikiHandler
{
    protected $pageManager;
    protected $securityController;

    public function run()
    {
        $this->pageManager = $this->getService(PageManager::class);
        $this->securityController = $this->getService(SecurityController::class);

        if ($this->securityController->isWikiHibernated()) {
            throw new Exception(_t('WIKI_IN_HIBERNATION'));
        };
        if (!$this->wiki->UserIsAdmin()) {
            return null;
        }

        $output = 'ℹ️ Adding GererSauvegardes pages.... ';
        $page = $this->pageManager->getOne('GererSauvegardes');
        if (empty($page)) {
            list($updatePagesState, $message) = $this->addGererSauvegardesPage();
            if ($updatePagesState) {
                $output .= '✅ Done !<br />';
            } else {
                $output .= '<span class="label label-warning">! '._t('UPDATE_ADMIN_PAGES_ERROR').'</span>'.'<br />'.$message;
            }
        } else {
            $output .= '✅ Done !<br />';
        }

        // set output
        $this->output = str_replace(
            '<!-- end handler /update -->',
            $output.'<!-- end handler /update -->',
            $this->output
        );
        return null;
    }

    /**
     * method to update GererSauvegardes page
     * @return array [bool true/false, string|null errorMessage]
     */
    private function addGererSauvegardesPage(): array
    {
        $pageContent =
        <<<CONTENT
        {{nav class="nav nav-tabs" links="GererConfig, GererMisesAJour, GererSauvegardes" titles="Fichier de conf,Mises à jour / extensions,Sauvegardes" }}
        
        {{adminbackups}}
        CONTENT;
        $output = '';
        $linkTracker = $this->getService(LinkTracker::class);
        if ($this->getService(PageManager::class)->save('GererSauvegardes', $pageContent) !== 0) {
            $output .= (!empty($output) ? ', ' : '')._t('NO_RIGHT_TO_WRITE_IN_THIS_PAGE').'GererSauvegardes';
        } else {
            // save links
            $linkTracker->registerLinks($this->getService(PageManager::class)->getOne('GererSauvegardes'));
        }
        return [empty($output),$output];
    }
}
