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
    'AB_management_adminbackups_label' => "Gestion des sauvegardes",
    // Commons
    'ARCHIVES' => 'Sauvegardes',
    'ONLY_FOR_ADMINS' => 'Seulement pour les administrateurs',

    // actions/AdminBackupsAtion.php
    'ADMIN_BACKUPS_TITLE' => 'Gestion des sauvegardes',
    'ADMIN_BACKUPS_ARCHIVES_LIST' => 'Liste des sauvegardes',
    'ADMIN_BACKUPS_ARCHIVE_FILENAME' => 'Nom du fichier',
    'ADMIN_BACKUPS_ARCHIVE_TYPE' => 'Type',
    'ADMIN_BACKUPS_ARCHIVE_TYPE_FULL' => 'Sauvegarde complète',
    'ADMIN_BACKUPS_ARCHIVE_TYPE_ONLY_FILES' => 'Seulement les fichiers',
    'ADMIN_BACKUPS_ARCHIVE_TYPE_ONLY_DATABASES' => 'Seulement la base de données',
    'ADMIN_BACKUPS_ARCHIVE_SIZE' => 'Taille',
    'ADMIN_BACKUPS_CREATE' => 'Créer une sauvegarde',
    'ADMIN_BACKUPS_START' => 'Démarrer',
    'ADMIN_BACKUPS_STOP' => 'Arrêter',
    'ADMIN_BACKUPS_STOP_BACKUP' => 'Arrêter la sauvegarde',
    'ADMIN_BACKUPS_ADVANCED_PARAMS' => 'Paramètres avancés',
    'ADMIN_BACKUPS_ADVANCED_EXCLUDED_FILES' => 'Fichiers exclus',
    'ADMIN_BACKUPS_ADVANCED_EXTRA_FILES' => 'Fichiers supplémentaires',
    'ADMIN_BACKUPS_CONFIRM_DELETE_FILES' => 'Confirmer la suppression des fichiers',

    'EDIT_CONFIG_GROUP_ARCHIVE' => 'Archivage',
    'EDIT_CONFIG_HINT_ARCHIVE[PRIVATEPATH]' => 'Localisation des sauvegardes (vide = dossier temporaire si possible)',
    'EDIT_CONFIG_HINT_ARCHIVE[CALL_ARCHIVE_ASYNC]' => 'Lancer les opérations de sauvegardes en arrière-plan (true/false)',
    'EDIT_CONFIG_HINT_ARCHIVE[MAX_NB_FILES]' => 'Nombre maximum de fichiers de sauvegarde à conserver (min. 3)',

    // templates/autoupdate/core.twig
    'ARCHIVE_MANAGE_BACKUPS' => 'Gérer les sauvegardes',

    // templates/preupdate-backups.twig
    'ADMIN_BACKUPS_CREATING' => 'Création d\'une sauvegarde',
    'ADMIN_BACKUPS_FORCE_UPDATE' => 'Forcer une mise à jour sans sauvegarde',
    'ADMIN_BACKUPS_BY_PASS' => 'Mettre à jour sans sauvegarde',
];
