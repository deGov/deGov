# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.2.0] - IN DEVELOPMENT
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
- Media entities search. Two different views were added for media management 
  (special permission added), the other for all users to search media elements. 
  Only the elements that have field_include_search checkbox enabled are allowed 
  to be searchable for all.
- New field for ogg video files in the video_upload media entity.
- Adds opportunity to use separate fields for each view argument in views
  reference widget. 

### Changed
- Refactoring and styling of the event teaser.
- Updated paragraph selection field settings with new added paragraph modules.
- Exclude Lightning search from the installation profile.
- Replaced logo, favicon and description in theme.
- Video files in the video_upload media entity are not required anymore.
- The field type of the argument to would be changed to entity reference if it
  is applicable to make it easy to find the correct filter in views reference widget.

### Fixed
- Merged duplicate press views in a single latest press view.
- Removed Slick as local library and replaced it with a composer drupal-library.
- Fix wrong attribute usages in the slideshow module libraries.
- Required empty paragraph fields now show a meaningfull error message.
- Social media buttons show under the content tags.
- Missing functionality fixes for pause/play in slick sliders.
- Warning on pages where an OSM map is included.