# Access control

First of all it should be decided how the client understands the Sections of the site. Either it is by menu items and hierarchy or this could be done with Taxonomy terms structure. Most of the module base their functionality on this two principles.

Content access module is very flexible but also really overcomplicated, because mostly there is no need to set the permission granularity so deep up to user per node.

## Modules available:

* Workbench access: [https://www.drupal.org/project/workbench_access](https://www.drupal.org/project/workbench_access)
* Group: [https://www.drupal.org/project/group](https://www.drupal.org/project/group)
* Permissions by term: [https://www.drupal.org/project/permissions_by_term](https://www.drupal.org/project/permissions_by_term)

### Workbench access
This module has no dependency on Workbench module. By default there is 2 methods to build the access scheme: menu structure and taxonomy structure. Module has extended documentation available here [https://www.drupal.org/documentation/modules/workbench_access](https://www.drupal.org/documentation/modules/workbench_access). The most important part is configuration [https://www.drupal.org/node/1171382](https://www.drupal.org/node/1171382).

Current version available is 8.x-1.0-alpha-4. The last module update was on May, 31, 2017.

User interface allows to set the permissions in admin interface for every content type and menu/taxonomy with help of defining the "Sections" of the site. The sections list is built automatically based on menus or vocabularies. There is an option to select on per user basis as well as per role for each menu item.

Admin interface is pretty clear and understandable. The only thing that should be taken into account is that there should be a field on the content type that associate the "Section" with the node. In case of Menu scheme, the menu item should be created from node add/edit form with a checkbox "Create a menu item for this node". In case of Taxonomy term based scheme you need to select the field from the list the references the taxonomy term. So each node should have the term reference field to be properly checked.

Field property module [http://drupal.org/project/field_property](http://drupal.org/project/field_property) is recommended to be used with workbench access in case of Term related scheme. This is important when using the revisions, because while editing the content, taxonomy term reference field could be changed from one revision to another.

Module depends on node, taxonomy and menu modules.

### Group
This module is good for having separate access to the content based on the group. It is not possible to use this approach for us, because the content should be restructured in a way of having the groups first and then the user can add/edit the content inside the group.

### Permissions by term
This is a lightweight version of the workbench access module in case of taxonomy term scheme. This module adds the field to taxonomy term with the options to allow the access by role or by individual user. The node is supposed to have at least 1 taxonomy term reference field for the module to detect the access rules. No other configuration is needed.
Module version is stable 8.x-1.9 and is supported by big companies [ttps://dev.acquia.com/blog/drupal-8-module-of-the-week/drupal-8-module-of-the-week-permissions-by-term/18/07/2016/16251](https://dev.acquia.com/blog/drupal-8-module-of-the-week/drupal-8-module-of-the-week-permissions-by-term/18/07/2016/16251). 

The last module update was May 9, 2017. 

Module depends only on taxonomy module.