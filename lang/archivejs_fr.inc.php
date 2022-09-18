<?php

/*
 * This file is part of the YesWiki Extension archive.
 *
 * Authors : see README.md file that was distributed with this source code.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    // /javascripts/actions/admin-backups.js
    "ADMIN_BACKUPS_LOADING_LIST" => "Chargement de la liste des sauvegardes",
    "ADMIN_BACKUPS_NOT_POSSIBLE_TO_LOAD_LIST" => "Impossible de mettre à jour la liste des sauvegardes",
    "ADMIN_BACKUPS_DELETE_ARCHIVE" => "Suppression de {filename}",
    "ADMIN_BACKUPS_DELETE_ARCHIVE_POSSIBLE_ERROR" => "Une erreur pourrait avoir eu lieu en supprimant {filename}",
    "ADMIN_BACKUPS_DELETE_ARCHIVE_SUCCESS" => "Suppression réussie de {filename}",
    "ADMIN_BACKUPS_DELETE_ARCHIVE_ERROR" => "Suppression impossible de {filename}",
    "ADMIN_BACKUPS_NO_ARCHIVE_TO_DELETE" => "Aucune sauvegarde à supprimer",
    "ADMIN_BACKUPS_DELETE_SELECTED_ARCHIVES" => "Suppression des sauvegardes sélectionnées",
    "ADMIN_BACKUPS_RESTORE_ARCHIVE" => "Restauration de {filename}",
    "ADMIN_BACKUPS_RESTORE_ARCHIVE_POSSIBLE_ERROR" => "Une erreur pourrait avoir eu lieu en restraurant {filename}",
    "ADMIN_BACKUPS_RESTORE_ARCHIVE_SUCCESS" => "Restauration réussie de {filename}",
    "ADMIN_BACKUPS_RESTORE_ARCHIVE_ERROR" => "Restauration impossible de {filename}",
    "ADMIN_BACKUPS_START_BACKUP" => "Lancement d'une sauvegarde",
    "ADMIN_BACKUPS_START_BACKUP_SYNC" => "Lancement d'une sauvegarde en direct (moins stable)\n".
        "Il ne sera pas possible de mettre à jour le statut en direct\n".
        "Ne pas fermer, ni rafraîchir cette fenêtre !",
    "ADMIN_BACKUPS_STARTED" => "Sauvegarde lancée",
    "ADMIN_BACKUPS_START_BACKUP_ERROR" => "Lancement de la sauvegarde impossible",
    "ADMIN_BACKUPS_UPDATE_UID_STATUS_ERROR" => "Impossible de mettre à jour le statut de la sauvegarde",
    "ADMIN_BACKUPS_UID_STATUS_NOT_FOUND" => "Les informations de suivi n'ont pas été trouvées",
    "ADMIN_BACKUPS_UID_STATUS_RUNNING" => "Sauvegarde en cours",
    "ADMIN_BACKUPS_UID_STATUS_FINISHED" => "Sauvegarde terminée",
    "ADMIN_BACKUPS_UID_STATUS_NOT_FINISHED" => "Il y a un problème car la sauvegarde n'est plus en cours et elle n'est pas terminée !",
    "ADMIN_BACKUPS_UID_STATUS_STOP" => "Sauvegarde arrêtée",
    "ADMIN_BACKUPS_STOP_BACKUP_ERROR" => "Erreur : impossible d'arrêter la sauvegarde",
    "ADMIN_BACKUPS_STOPPING_ARCHIVE" => "Arrêt en cours de la sauvegarde",
    "ADMIN_BACKUPS_CONFIRMATION_TO_DELETE" => "Les fichiers suivants seront supprimés par la sauvegarde.\n".
        "Veuillez confirmer leur suppression en cochant la case ci-dessous.\n<pre>{files}</pre>",
    "ADMIN_BACKUPS_START_BACKUP_ERROR_ARCHIVING" => "Lancement de la sauvegarde impossible \n" .
        "Car une sauvegarde semble être déjà en cours.\n".
        "Si ça n'est pas le cas, se rendre dans la page 'GererConfig' pour vider la valeur\n".
        "du paramètre `wiki_status` dans la partie `Sécurité`",
    "ADMIN_BACKUPS_START_BACKUP_ERROR_HIBERNATE" => "Lancement de la sauvegarde impossible \n" .
        "Car le site est en hibernation.\n".
        "Pour le sortir de cet état, se rendre dans la page 'GererConfig' pour vider la valeur\n".
        "du paramètre `wiki_status` dans la partie `Sécurité`",
    "ADMIN_BACKUPS_START_BACKUP_PATH_NOT_WRITABLE" => "Lancement de la sauvegarde impossible \n" .
        "Car le dossier de sauvegarde n'est pas accessible en écriture.\n".
        " - Vérifier la validité du paramètre 'archive[privatePath]', dans la page 'GererConfig' (rubrique 'Archivage')\n".
        " - si ce paramètre est vide, le remplir avec un chemin non accessible sur le internet\n".
        " - Vérifier que le dossier est bien accessible pour 'php' (si 'archive[privatePath]' est vide, c'est le dossier '/tmp' qui est utilisé)",
    "ADMIN_BACKUPS_FORCED_UPDATE_NOT_POSSIBLE" => "Mise à jour forcée impossible",
    "ADMIN_BACKUPS_UID_STATUS_FINISHED_THEN_UPDATING" => "Mise à jour lancée (veuillez patienter)",
    "ADMIN_BACKUPS_START_BACKUP_CANNOT_EXEC" => "Lancement de la sauvegarde impossible \n" .
    "Car il n'est pas possible de lancer des commandes console sur le serveur.\n".
    " - Vérifier que les commandes 'exec', 'proc_open', 'proc_terminate' ... sont autorisées pour php",

];
