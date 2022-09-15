<?php
/*
 * This file is part of the YesWiki Extension archive.
 *
 * Authors : see README.md file that was distributed with this source code.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace YesWiki\Archive\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use YesWiki\Core\ApiResponse;
use YesWiki\Archive\Controller\ArchiveController;
use YesWiki\Archive\Service\ArchiveService;
use YesWiki\Core\YesWikiController;

class ApiController extends YesWikiController
{
    /**
     * @Route("/api/archives/{id}", methods={"GET"}, options={"acl":{"public", "@admins"}},priority=3)
     */
    public function getArchive($id)
    {
        return $this->getService(ArchiveController::class)->getArchive($id);
    }

    /**
     * @Route("/api/archives/uidstatus/{uid}", methods={"GET"}, options={"acl":{"public", "@admins"}},priority=3)
     */
    public function getArchiveStatus($uid)
    {
        return $this->getService(ArchiveController::class)->getArchiveStatus($uid);
    }

    /**
     * @Route("/api/archives/archivingStatus/", methods={"GET"}, options={"acl":{"public", "@admins"}},priority=3)
     */
    public function getArchivingStatus()
    {
        return new ApiResponse(
            $this->getService(ArchiveService::class)->getArchivingStatus(),
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/api/archives/forcedUpdateToken/", methods={"GET"}, options={"acl":{"public", "@admins"}},priority=3)
     */
    public function getForcedUpdateToken()
    {
        $token = $this->getService(ArchiveService::class)->getForcedUpdateToken();
        return new ApiResponse(
            ['token'=>$token],
            empty($token) ? Response::HTTP_INTERNAL_SERVER_ERROR : Response::HTTP_OK
        );
    }

    /**
     * @Route("/api/archives/", methods={"GET"}, options={"acl":{"public", "@admins"}},priority=3)
     * @Route("/api/archives", methods={"GET"}, options={"acl":{"public", "@admins"}},priority=3)
     */
    public function getArchives()
    {
        $archiveService = $this->getService(ArchiveService::class);
        return new ApiResponse(
            $archiveService->getArchives(),
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/api/archives/{id}", methods={"POST"}, options={"acl":{"public", "@admins"}},priority=3)
     */
    public function archiveAction($id)
    {
        return $this->getService(ArchiveController::class)->manageArchiveAction($id);
    }

    /**
     * @Route("/api/archives", methods={"POST"}, options={"acl":{"public", "@admins"}},priority=3)
     */
    public function archivesAction()
    {
        return $this->getService(ArchiveController::class)->manageArchiveAction();
    }

    /**
     * @Route("/api/archives/stop/{id}", methods={"GET"}, options={"acl":{"public", "@admins"}},priority=4)
     */
    public function stopArchive($id)
    {
        return $this->getService(ArchiveController::class)->stopArchive($id);
    }
}
