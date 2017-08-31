# Manual configuration

The purpose of this page is to keep track of manual configuration of settings that are not worthy or sufficiently general to be put into code.

## Theme settings
### Breadcrumb
For the breadcrumb settings to work properly, two settings of the nrw_base_theme have to be changed:

```
nrw_base_theme.settings.yml:
breadcrumb_home: 1
breadcrumb_title: 0
```

/admin/appearance/settings/nrw_base_theme -> Bootstrap Settings -> Komponenten -> Breadcrumbs →

* "Show Home breadcrumb link" checked
* "Show current page title at end" not checked
