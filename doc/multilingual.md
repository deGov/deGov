# Multilingual

Testing hints:

* go to /admin/config/regional/language and add "English"
* optional: go to /admin/config/regional/language/detection/url and configure a prefix for German (de) - If you don't do this, the german frontpage will be / and the english frontpage will be /en (otherwise /de and /en)
* go to /admin/modules and enable degov - Multilingual
* 
The modul will automatically configure the current front page setting from system.site.page.front as the default front page for all enabled languages. So nothing should change after enabling the module, except that the two example multilingual templates in the theme folder should already be active. To verify that, switch languages in the frontend and look at the footer.

* go to /admin/config/degov/multilingual and configure different front pages for the languages
* go back to the front page and switch languages

When changing the front page settings, the front page cache is flushed right away. I tested this with Internal Page Cache and Dynamic Page Cache.