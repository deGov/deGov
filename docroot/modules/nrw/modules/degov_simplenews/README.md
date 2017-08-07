# deGov - Simplenews

This module provides default configuration for the simplenews newsletter module.

Multiple newsletters can be created and subscribed to. Upon installation,
a default deGov Newsletter was configured. Changing the configuration of this
newsletter as well as adding more newsletters can be carried out here:

/admin/config/services/simplenews

The default configuration for new newsletters, as well as settings for subscribing to
and sending of newsletters, can be changed here: 

/admin/config/services/simplenews/settings/newsletter

Newsletter issues can be created by adding a simplenews_issue node:

/node/add/simplenews_issue

Newsletter issues can be sent on the newsletter tab of simplenews_issue nodes. We strongly
recommend sending a test newsletter from there before sending out the newsletter to all
recipients.

By default, newsletters are sent immediately. However, we recommend setting up cron and
enabling the "use cron" checkbox in the settings for sending of newsletter.

You can add a newsletter subscription for on the block layout page:
 
/a0dmin/structure/block

Also, make sure that your webserver is allowed to use the configured sender addresses
of your newsletter issues. You might need additional settings in your server setup or
configure your site to send mails by smtp.
 