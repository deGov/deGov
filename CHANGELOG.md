# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.3.0] - IN DEVELOPMENT
### Added
- Added role 'usermanager'.

### Changed
- updated permissions for roles editor and manager.

### Fixed
- Patched the config rewrite module to allow optional config rewrites.
- Workbench access default settings for simplenews and press content types.
- Padding fixed for CKEDITOR embedded images.
- Placeholder languages in the language switcher replaced by available site languages.

## [1.2.2] - 2017-08-24
### Fixes
- Installation fixes, that required dependencies.
- Fix for install hook in node_event set first day of week.

## [1.2.1] - 2017-08-23
### Fixes
- Submenus are separated in to their own section.
- View reference paragraph filtering options improved.
- Media reference paragraph view mode of target media is now applied.
- Border styling for referenced entites.

### Changed
- Removal of old update hooks and folders.

## [1.2.0] - 2017-08-18
### Added
- This changelog file to serve as a track record of all releases.
- New module to override image styles and view modes.
- Dropzonejs support in the media browser.
- New tabs in the media browser for uploading image, video and documents.
- Custom configuration update service for modules config and block config.
- Patched core to use an install hook in theme and added default theme settings.
- New module 'deGov - Password Policy' added.
- Default block configuration for 'deGov - Inhaltssuche'.
- Block reference paragraph.
- View mode selection for media reference.
- Media entities search. Two different views were added for media management 
  (special permission added), the other for all users to search media elements. 
  Only the elements that have field_include_search checkbox enabled are allowed 
  to be searchable for all.
- New field to support ogg video files in the video_upload media entity.
- New service "degov_config.module_updater" for config updates from an update hook.
  Use the service by adding \Drupal::service('degov_config.module_updater')->applyUpdates('module_name', 'update_version')
  to your update hook and add a 'config/update_N' folder. In the folder
  create a place an 'install' folder for new configurations, a 'block' folder
  for new blocks and a 'rewrite' folder for configuration updates.
  Updating the 'config/install' folder is still required for fresh installations.
- Adds opportunity to use separate fields for each view argument in views
  reference widget.
- Added scripts to execute tests(BeHat, PHPUnit) in a unified fashion, added small tech. documentation for setup.
- Added degov_media_audio module for audio files (mp3, ogg).
- Added settings for restricting available view modes for "Inhaltsreferenz".

### Changed
- Refactoring and styling of the event teaser.
- Updated paragraph selection field settings with new added paragraph modules.
- Exclude Lightning search from the installation profile.
- Replaced logo, favicon and description in theme.
- Video files in the video_upload media entity are not required anymore.
- The field type of the argument to would be changed to entity reference if it
  is applicable to make it easy to find the correct filter in views reference widget.
- Changes argument fields of type textfield in the views reference paragraph
  to an entity reference auto-completion field if applicable.
- Enable all available node types for paragraph node_reference.
- Enable all available media bundles for paragraph media_reference.
- Change "NRW View Paragraph Selection Overrides" module name to "NRW Field Configuration Overrides".
- Base search dependencies are now split in a new module degov_search_base.
- Change block reference paragraph in the way that it can reference any block,
  not only the ones that were already placed into the layout of the theme.

### Fixed
- Merged duplicate press views in a single latest press view.
- Removed Slick as local library and replaced it with a composer drupal-library.
- Fix wrong attribute usages in the slideshow module libraries.
- Required empty paragraph fields now show a meaningfull error message.
- Social media buttons show under the content tags.
- Missing functionality fixes for pause/play in slick sliders.
- Warning on pages where an OSM map is included.
- Small styling changes in the slider to prevent overflows.
- Small styling changes in footer for headers.
- Links in header paragraphs are now white to contrast the background.
- The tags field is moved to be hidden from display.
- CKEditor embed media button now works.
