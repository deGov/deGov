# Development Workflow


## General
The master branch is deployed on platform.sh.
[URL](https://master-7rqtwti-i4gmek2ltnseq.eu.platform.sh)
Please ask us for credentials.

You need a Bitbucket oauth key/scret for composer update operations. You can get one [here](https://bitbucket.org/account/user/<user>/api) → add consumer → tick "read" and "write" → save

## Branching
Always create a branch for each given "Arbeitspaket".
Branches should be named after the "Arbeitspaket", just how it is named in the corresponding JIRA issue, e.g. AP-D4-5.1

## Local setup - Part 1 - platform setup
> Your remote here is set to platform. So, if you commit and push, changes will be visible on platform. **The code does not get pushed into bitbucket**.
> 
All code must go into bitbucket. You also branch off from bitbucket, not from platform. This means, that you don't need to set-up the platform environment, but it is practical for getting a database dump and to test stuff.

> **Follow the steps below (Part 2) in order to push into bitbucket**.

For local develompent, install [https://docs.platform.sh/overview/cli.html](https://docs.platform.sh/overview/cli.html)

In order to get the code/database from platform we retrieve it from platform:

###List projects
```
~/# platform

Your projects are: 
+---------------+---------------------------+-------------------------------------------------+
| ID            | Title                     | URL                                             |
+---------------+---------------------------+-------------------------------------------------+
| i4gmek2ltnseq | deGov_nrw_mik_ressort     | https://eu.platform.sh/#/projects/i4gmek2ltnseq |
+---------------+---------------------------+-------------------------------------------------+
```

### Checkout
```
~/# platform get i4gmek2ltnseq MIK_platform

Downloading project deGov_nrw_mik_ressort (i4gmek2ltnseq)
  Cloning into '/home/MIK_platform'...
  remote: counting objects: 625, done.        
  Receiving objects: 100% (625/625), 2.03 MiB | 0 bytes/s, done.
  Resolving deltas: 100% (188/188), done.

The project deGov_nrw_mik_ressort (i4gmek2ltnseq) was successfully downloaded to: MIK_platform

You can build the project with: 
    cd MIK_platform
    platform build
```

### Build
```
~# cd MIK 
~/MIK_platform# platform build

Building application app (runtime type: php:7.1)
Installing php dependencies with 'composer': drush/drush, drupal/console

Loading composer repositories with package information
Updating dependencies (including require-dev)
Package operations: 46 installs, 0 updates, 0 removals
  - Installing composer/installers (v1.3.0) Loading from cache
  - Installing webmozart/assert (1.2.0) Loading from cache
.
.
.
```

### Get the database
```
~/MIK_platform# platform sql-dump


Creating SQL dump file: //MIK_platform/i4gmek2ltnseq--master--dump.sql
Warning: the dump file is not excluded by Git
  You should probably exclude these files using .gitignore:
    *--dump.sql
```

### Install the database and configure settings.local.php
1. Create a local database and import the dump (e.g. mysql -u mik -p mik < i4gmek2ltnseq–master–dump.sql)
2. Setup your local host stuff (apache and such)
3. Edit the docroot/sites/default/settings.local.php and add the DB credentials
4. Also add hash_salt variable to the settings: $settings['hash_salt'] = 'REALLYLONGSALT_DEGOVISAWESOME';

### Checkout different branch
```
~/MIK_platform# platform

Welcome to Platform.sh!

Project title: deGov_nrw_mik_ressort
Project ID: i4gmek2ltnseq
Project dashboard: https://eu.platform.sh/#/projects/i4gmek2ltnseq

Your environments are: 
+-------------------+-------------------+----------+
| ID                | Name              | Status   |
+-------------------+-------------------+----------+
| master*           | Master            | Active   |
| develop           | develop           | Active   |
| feature/AP-D4-5   | feature/AP-D4-5   | Inactive |
| feature/AP-D4-6   | feature/AP-D4-6   | Inactive |
| feature/AP-D4-7.1 | feature/AP-D4-7.1 | Active   |
| feature/AP-D6-14a | feature/AP-D6-14a | Inactive |
| feature/AP-D6-18  | feature/AP-D6-18  | Inactive |
| feature/AP-D6-4   | feature/AP-D6-4   | Inactive |
| feature/AP-M2     | feature/AP-M2     | Active   |
| feature/AP-MIK1-1 | feature/AP-MIK1-1 | Inactive |
| feature/AP-R1     | feature/AP-R1     | Active   |
| feature/AP-V2     | feature/AP-V2     | Inactive |
+-------------------+-------------------+----------+
* - Indicates the current environment


~/MIK# platform checkout develop

  From git.eu.platform.sh:i4gmek2ltnseq
   * branch            develop    -> FETCH_HEAD
Creating local branch develop based on upstream platform/develop
  Switched to a new branch 'develop'
  Branch develop set up to track remote branch develop from platform.
  
```

### Local setup - Part 2 - bitbucket setup
> See Part 1 on how to get a database copy!

#### Clone the project / run composer
```
~/# git clone git@bitbucket.org:publicplan/degov_nrw_mik_ressort.git MIK
Cloning into 'MIK'...
remote: Counting objects: 625, done.
remote: Compressing objects: 100% (524/524), done.
remote: Total 625 (delta 193), reused 241 (delta 38)
Receiving objects: 100% (625/625), 2.03 MiB | 871.00 KiB/s, done.
Resolving deltas: 100% (193/193), done.


~/# cd MIK
~/MIK# composer install
...
```

#### Install the database and configure settings.local.php

1. Create a local database and import the dump (e.g. mysql -u mik -p mik < i4gmek2ltnseq–master–dump.sql)
2. Setup your local host stuff (apache and such)
3. Edit the docroot/sites/default/settings.local.php and add the DB credentials
4. Also add hash_salt variable to the settings: $settings['hash_salt'] = 'REALLYLONGSALT_DEGOVISAWESOME';

## Develop
Now you're ready to develop locally. Remember: all GIT operation need to be done on the bitbucket remote.

Once you're done with the local development of your Arbeitspaket, follow the next step.

### Create upgrade path
> From deGov/nrwGov v1.1.0 on (https://bitbucket.org/publicplan/degov_nrw_mik_ressort/branch/v1.1.0), we provide an upgrade path for existing installations.
The upgrade path will involve all minor releases, so in order to upgrade from e.g. v1.1.0 → v1.3.0, it will be mandatory to upgrade to v1.2.0 before (and run drush updb).
Why? Because between minor versions (v1.1, v1.2, ...) we provide update hooks for all changes. After each minor release, we will delete all the update hooks and start adding new ones. This way we avoid ever growing update code.

If your module changes the configuration from config/install or config/rewrite folders, all the changes should go into update_N hook. 

The analog of command

`drush config-import --partial --source=path_to_your_module/config/install`

is

`\Drupal::service('degov_config.updater')->configPartialImport('module_name', 'optional parameter - type of config: install or option folder (default = "install")');`

To re-import rewrites of configuration do:

`\Drupal::service('config_rewrite.config_rewriter')->rewriteModuleConfig('module_name');`

Also all other changes to database structure or small configuration changes should be present here. E.g.

```
/**
 * Updates date facet to be a date popup widget.
 */
function degov_search_content_update_8001() {
 // Set date facet widget configuration.
 $config_factory = \Drupal::configFactory();
 $config = $config_factory->getEditable('facets.facet.search_content_changed');
 $widget = $config->get('widget');
 $widget['type'] = 'degov_date_range_picker';
 $widget['config']['granularity'] = '4';
 $config->set('widget', $widget);
 $config->save(TRUE);
 // Flush plugin caches so our facets will be shown.
 \Drupal::service('plugin.cache_clearer')->clearCachedDefinitions();
}
```

Any configuration that is in YAML file could be loaded with function 

`\Drupal::configFactory()->getEditable('yaml_file_name_without_extension');`

Then you can change any setting from the configuration and save it again, see the example above.

Starting from release-1.2 it is possible to provide the updates in yml files. 

Example of update hook from metatags module:
```
/**
 * Add optional overwrite metatag fields to all installed deGov content types.
 */
function degov_metatags_update_8001() {
  \Drupal::service('degov_config.module_updater')->applyUpdates('degov_metatags', '8001');
}
```

The parameters of the applyUpdate methods are: 

1. Module name 
2. The update version

The cml files for updates should be placed into config/update_XXXX folder, where XXXX corresponds to module version that you have in the hook_update_XXXX and the same version should be placed into applyUpdates method as a parameter.

The structure of the config folder now might look like this:

```
config -
   - update_XXXX
		- block
		- install
		- optional
		- rewrite
```

You just need to place correct yml file to correct folder, e.g. for block placement place the file into block folder. Also all the changes should be reflected in config/install , config/block, config/rewrite and config/optional folders because on fresh install the module doesn't apply the updates.

### Changelog
Before creating a pull request, also make sure to update the CHANGELOG.md files in the project root (as from release-1.2 branch on).

### Commit and Test on platform
When you commit your changes in your branch and push them into Bitbucket these will be automatically transfered to platform.sh, where you can and should test before delivering for QA.

> When you first push your branch, platform will automatically create an inactive branch of the same name. See following screenshots on how to activate and test

### Create pull request
1. When you are done, you create a pull request to the development branch of the MIK repo.
2. Create a pull request from <your-feature-branch> to develop (when pushing from command line, you will get a ready link from Bitbucket → just copy to browser, but not before testing on platform.sh...)
3. Assign JIRA issue to "responsible" or whoever should do a QA from a technical perspective. Ideally, add the link to platform.sh deployed app.
4. Add any non-obvious things to the JIRA issue as comment, so QA can be fast and effective.
5. Quick notice on slack would be helpful as well
6. Wait for feedback. Ideally, your branch just gets merged!

### QA / merge
PMs and the manager of the repository reviews your branch online by looking at the environment on platform.sh. Also the manager reviews the source code and runs acceptance tests on the code. If everything is OK, the repository manager merges your branch into the develop branch of the drupal modules repository.

### Update main
The main branch on platform.sh is regularly updated and the changes in the repositories are pulled to the main environment

### Cleanup
The branch AP-V1 on platform.sh is destroyed, when everything is merged.
