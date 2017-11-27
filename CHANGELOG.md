# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.12.0] - 2017-11-27
### Changed
- Updated degov/modules to version 1.12.3.

## [1.11.1] - 2017-11-16
### Fixed
- Fixed Behat namespaces and PSR-4 Autoload path.
- Added composer resources to .gitignore

### Changed
- Updated Drupal to 8.4.x

## [1.11.0] - 2017-11-06
### Fixed
- Updated degov/modules to 1.11.1 - hotfix version.

## [1.10.0] - 2017-10-27
### Added
- Added logo upload field for content type organization.

### Fixed
- Fixed handler settings for header and sidebar right paragraphs for content type
  organization.

### Changed
- Remove dependency on views_reference to degov modules. Update views_reference to stable.
- Removed dependency on paragraphs in root composer and move it to degov modules.
- Removed patch to paragraphs 1.1 because paragraphs were updated to version 1.2.

## [1.9.0] - 2017-10-23
### Added
- Cron task configuration for running scheduled updates every 5 minutes on platform.
  According to documentation https://docs.platform.sh/configuration/app/cron.html it
  is the minimum interval possible.
- Redirect module has been added to the composer.lock file.
- Translations update is now part of deployment procedure.
- Added configuration for platform: memory_ limit, post_ and upload_max sizes

### Changed
- Original CHANGELOG.md content has been mainly moved to deGov modules folder.
  This CHANGELOG.md will from now on contain upgrade or project related info.
