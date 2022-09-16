/*
 * This file is part of the YesWiki Extension archive.
 *
 * Authors : see README.md file that was distributed with this source code.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

let rootsElements = ['.preupdate-backups-container'];
let isVueJS3 = (typeof Vue.createApp == "function");

let appParams = {
    data: function() {
        return {
            canForceUpdate: false,
            ready: false,
            updating: false,
            archiving: false,
            showAdvancedParams: false,
            currentArchiveUid: "",
            archiveMessage: "",
            archiveMessageClass: {
                alert: true,
                ['alert-info']: true
            },
            stoppingArchive: false,
            upgradeName: "",
            showReturn: true
        };
    },
    methods: {
        startArchive: function (){
            let archiveApp = this;
            archiveApp.updating = true;
            archiveApp.archiving = true;
            archiveApp.message = "";
            archiveApp.archiveMessage = _t('ADMIN_BACKUPS_START_BACKUP');
            archiveApp.archiveMessageClass = {alert:true,['alert-info']:true};
            $.ajax({
                method: "GET",
                url: wiki.url(`api/archives/archivingStatus/`),
                cache: false,
                success: function(data){
                    if (typeof data != "object" || !data.hasOwnProperty('canArchive')){
                        archiveApp.endStartingUpdateError();
                        return;
                    } else if (data.canArchive){
                        archiveApp.startArchiveNextStep();
                        return;
                    } else if (data.hasOwnProperty('archiving') && data.archiving) {
                        archiveApp.endStartingUpdateError(_t('ADMIN_BACKUPS_START_BACKUP_ERROR_ARCHIVING').replace(/\n/g,'<br>'));
                        return ;
                    } else if (data.hasOwnProperty('hibernated') && data.hibernated) {
                        archiveApp.endStartingUpdateError(_t('ADMIN_BACKUPS_START_BACKUP_ERROR_HIBERNATE').replace(/\n/g,'<br>'));
                        return ;
                    } else if (data.hasOwnProperty('privatePathWritable') && !data.privatePathWritable) {
                        archiveApp.endStartingUpdateError(_t('ADMIN_BACKUPS_START_BACKUP_PATH_NOT_WRITABLE').replace(/\n/g,'<br>'));
                        return ;
                    } else if (data.hasOwnProperty('canExec') && !data.canExec) {
                        archiveApp.endStartingUpdateError(_t('ADMIN_BACKUPS_START_BACKUP_CANNOT_EXEC').replace(/\n/g,'<br>'));
                        return ;
                    }
                    archiveApp.endStartingUpdateError();
                },
                error: function(){
                    archiveApp.endStartingUpdateError();
                }
            });
        },
        startArchiveNextStep: function(){
            let archiveApp = this;
            $.ajax({
                method: "POST",
                url: wiki.url(`api/archives`),
                data: {
                    action: 'startArchive',
                    params: {
                        savefiles: true,
                        savedatabase: true,
                        extrafiles: [],
                        excludedfiles: []
                    }
                },
                success: function(data){
                    archiveApp.archiveMessage = _t('ADMIN_BACKUPS_STARTED');
                    archiveApp.archiveMessageClass = {alert:true,['alert-info']:true};
                    archiveApp.currentArchiveUid = data.uid;
                    setTimeout(archiveApp.updateStatus, 2000);
                },
                error: function(){
                    archiveApp.endStartingUpdateError();
                }
            });
        },
        endStartingUpdateError: function(message = ""){
            let archiveApp = this;
            archiveApp.archiveMessage = message.length == 0 ? _t('ADMIN_BACKUPS_START_BACKUP_ERROR') : message;
            archiveApp.archiveMessageClass = {alert:true,['alert-danger']:true};
            archiveApp.updating = false;
            archiveApp.archiving = false;
            archiveApp.canForceUpdate = true;
        },
        stopArchive: function (){
            this.stoppingArchive = true;
            let archiveApp = this;
            $.ajax({
                method: "GET",
                url: wiki.url(`api/archives/stop/${archiveApp.currentArchiveUid}`),
                cache: false,
                success: function(data){
                    archiveApp.archiveMessage = _t('ADMIN_BACKUPS_STOPPING_ARCHIVE');
                    archiveApp.archiveMessageClass = {alert:true,['alert-warning']:true};
                },
                error: function(xhr,status,error){
                    archiveApp.archiveMessage = _t('ADMIN_BACKUPS_STOP_BACKUP_ERROR');
                    archiveApp.archiveMessageClass = {alert:true,['alert-danger']:true};
                    archiveApp.stoppingArchive = false;
                }
            });
        },
        updateStatus: function(){
            if (this.currentArchiveUid.length > 0){
                let archiveApp= this;
                $.ajax({
                    method: "GET",
                    url: wiki.url(`api/archives/uidstatus/${archiveApp.currentArchiveUid}`),
                    cache: false,
                    success: function(data){
                        if (data.stopped){
                            archiveApp.endUpdatingStatus(_t('ADMIN_BACKUPS_UID_STATUS_STOP'),'success');
                        } else if (!data.started){
                            archiveApp.endUpdatingStatus(_t('ADMIN_BACKUPS_UID_STATUS_NOT_FOUND'),'warning');
                            setTimeout(archiveApp.loadArchives, 3000);
                        } else if (data.finished){
                            archiveApp.startForcedUpdate(_t('ADMIN_BACKUPS_UID_STATUS_FINISHED')+'<br/>'+_t('ADMIN_BACKUPS_UID_STATUS_FINISHED_THEN_UPDATING'));
                        } else if (!data.running) {
                            archiveApp.endUpdatingStatus(_t('ADMIN_BACKUPS_UID_STATUS_NOT_FINISHED'),'danger');
                        } else if (archiveApp.stoppingArchive) {
                            archiveApp.archiveMessage = _t('ADMIN_BACKUPS_STOPPING_ARCHIVE');
                            archiveApp.archiveMessage += "<pre>"+data.output.split("\n").slice(-5).join("<br>")+"</pre>";
                            setTimeout(archiveApp.updateStatus, 1000);
                        } else {
                            archiveApp.archiveMessage = _t('ADMIN_BACKUPS_UID_STATUS_RUNNING');
                            archiveApp.archiveMessage += "<pre>"+data.output.split("\n").slice(-5).join("<br>")+"</pre>";
                            archiveApp.archiveMessageClass = {alert:true,['alert-secondary-2']:true};
                            setTimeout(archiveApp.updateStatus, 1000);
                        }
                    },
                    error: function(xhr,status,error){
                        archiveApp.endUpdatingStatus(_t('ADMIN_BACKUPS_UPDATE_UID_STATUS_ERROR'),'danger');
                        setTimeout(archiveApp.loadArchives, 3000);
                    }
                });
            } else {
                this.endUpdatingStatus();
            }
        },
        endUpdatingStatus: function (message = "", className = "info"){
            this.archiveMessage = message;
            this.archiveMessageClass = {alert:true,[`alert-${className}`]:true};
            this.updating = false;
            this.archiving = false;
            this.stoppingArchive = false;
            this.currentArchiveUid = "";
        },
        forceUpdate: function() {
            let archiveApp = this;
            $.ajax({
                method: "GET",
                url: wiki.url(`api/archives/forcedUpdateToken/`),
                cache: false,
                success: function(data){
                    if (
                        typeof archiveApp.upgradeName != "string" ||
                        archiveApp.upgradeName.length == 0 ||
                        typeof data != "object" || 
                        !data.hasOwnProperty('token') || 
                        typeof data.token != "string" || 
                        data.token.length == 0){
                        archiveApp.endStartingUpdateError(_t('ADMIN_BACKUPS_FORCED_UPDATE_NOT_POSSIBLE'));
                        archiveApp.canForceUpdate = false;
                    } else {
                        window.location = wiki.url(wiki.pageTag,{upgrade:archiveApp.upgradeName,forcedUpdateToken:data.token});
                    }
                },
                error: function(){
                    archiveApp.endStartingUpdateError(_t('ADMIN_BACKUPS_FORCED_UPDATE_NOT_POSSIBLE'));
                    archiveApp.canForceUpdate = false;
                }
            });
        },
        bypassArchive: function(){
            let archiveApp = this;
            if (archiveApp.archiving){
                archiveApp.stopArchive();
                setTimeout(() => {
                    this.startForcedUpdate(_t('ADMIN_BACKUPS_UID_STATUS_FINISHED_THEN_UPDATING'));
                }, 2000);
            } else {
                this.startForcedUpdate(_t('ADMIN_BACKUPS_UID_STATUS_FINISHED_THEN_UPDATING'));
            }
        },
        startForcedUpdate: function(message){
            this.endUpdatingStatus(message,'success');
            this.showReturn = false;
            this.forceUpdate();
        }
    },
    mounted (){
        this.upgradeName = $(isVueJS3 ? this.$el.parentNode : this.$el).data("upgrade");
        if (isVueJS3){
            $(this.$el.parentNode).on(
                "dblclick",
                function (e) {
                  return false;
                }
              );
        } else {
            $(this.$el).on(
                "dblclick",
                function (e) {
                  return false;
                }
              );
        }
        this.startArchive();
    }
};

if (isVueJS3){
    let app = Vue.createApp(appParams);
    rootsElements.forEach(elem => {
        app.mount(elem);
    });
} else {
    rootsElements.forEach(elem => {
        new Vue({
            ...{el:elem},
            ...appParams
        });
    });
}