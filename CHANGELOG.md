# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.9.0] - 2017-10-23
### Added
- Cron task configuration for running scheduled updates every 5 minutes on platform.
  According to documentation https://docs.platform.sh/configuration/app/cron.html it
  is the minimum interval possible.
- Redirect module has been added to the composer.lock file.
- Translations update is now part of deployment procedure.
- Added mik_node_organization module.
- Added configuration for platform: memory_ limit, post_ and upload_max sizes

### Changed
- Original CHANGELOG.md content has been mainly moved to deGov modules folder.
  This CHANGELOG.md will from now on contain upgrade or project related info.
