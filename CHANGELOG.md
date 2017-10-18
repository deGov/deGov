# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.8.0] - 2017-10-17 
### Added
- Patched Geocoder to support an API key - 2699861.
- Menu breadcrumb module so breadcrumbs are based on menu path.
- Teaser subtitle has been added to the slim view modes.

### Changed
- degov_views_helper functionality was transfered to degov_common module.
- Added API key support for Geocoder. Patch is applied.
- Added control field for optional media download.
- Added the special char button to the editor toolbar.
- Date format in press from medium to short.
- Added Workbench module and granted permission 'access workbench' to the editor role.
- Revoked the 'access content overview' permission from the editor role.
- Patched Entity Embed module to support linking and added autocompletion.
- "Save to my media library" checkbox in media was removed from the form.
- Include in search field was renamed to "Mediathek".

### Fixed
- Template suggestions now can be set from different modules for the same bundle of entity type.
- The image preview in Media reference paragraph preview mode is now not overlapping the edit buttons.
- Completely seperated NRW and deGov code the degov_media_address and nrw_media_address module.
- Added !important to header title in print css for print preview in chrome.
- Timezone corrected in twig templates for events.
- If media duration is empty (NULL, '' or 0) it is now not displayed in frontend.
- If the duration field already has value, it is not updated. It helps to reduce hits to Youtube and Vimeo APIs.
- Media view mode selector doesn't break anymore if more than one media reference in content.

## [1.7.0] - 2017-09-22
### IMPORTANT: UPGRADE PATH - To-do's before upgrading
- Disable module degov_vsm_search before updating to 1.7.0 code.
  The module can be re-enabled after upgrade, only the machine name has changed.

### Added
- Styling for having a visually visible menu active trail.
- Enables platform support for imagick toolkit and adds contrib module.
- Added aria to social media settings for accessibility.

### Changed
- Split functionality for specific maps into a seperate module.
- New view mode templates are moved to the theme layer.
- Video subtitle paragraph module is now a submodule of video upload.

### Fixed
- Starterkit theme has been updated to reflect latest stable theme.
- Set an active trail class for header menu items.
- Enable the second level menu to be always visible in the main navigation.
- Adds maximum width for images to prevent overscan of container.

## [1.6.5] - 2017-09-22
### Added
- Memcached support and new service 'cache.backend.degov_common' for database fallback.
- Media reference view mode added for video, video upload and audio

### Fixed
- Make mail field in user profile mandatory if degov_simplenews module is enabled, because it is required for subscriptions.

## [1.6.4] - 2017-09-20
### Added
- Multilingual menu support added.

## [1.6.3] - 2017-09-19
### Added
- Provided additional info to composer patches to prevent the 'no interaction error' on composer
  deployments with flags '--no-progress --prefer-dist --optimize-autoloader --no-interaction --no-ansi'.
- Adds a tags filter field to the media content overview page.

### Fixed
- Patches entity browser views that do not have use_ajax explicitly enabled - 2902831.
- Fixed problem with bad requests to youtube API.

## [1.6.2] - 2017-09-15
### Added
- Added forgotten missing media templates to nrw theme.

## [1.6.1] - 2017-09-15
### Added
- Added missing media templates to nrw theme.

## [1.6.0] - 2017-09-15
### Added
- Drush development dependency potx added for translations extraction.
- Stage file proxy development dependency added to receive remote resources.
- New calendar view has been added for press content.
- Added testing documentation.
- Added author and copyright filter to media overview page.
- Asset fields (accessibility, duration, transcription and language) for video and audio media types.
- Added admin_links_access_filter module for admin toolbar restriction by permission.
- Added getid3 library for retrieving duration of media.
- Support for additional table properties in ckeditor.

### Changed
- Social media and tags are refactored to be outside of the header paragraph.
- Specific node content fields are rearranged to be above the common field groups.
- Changed view mode teaser for event and press, used in views and search.

### Fixed
- Patches are fixed and updated so no warnings are thrown during installation.
- Nodes view mode preview when a view is added in the sidebar.
- Removes PHP 7 code, to continue support of PHP 5.6.
- URLs in emails are now absolute as well as image sources and other URI attributes.
- Corrects the redirect unsubscription URL for simplenews with multilingual frontpage enabled.
- Patches core bug to allow sending newsletters of simplenews with bulk operation - 2849674.
- Slim view mode images are now rendered as small landscape 2:1.
- Cleanup and fixes copyright field replacement in views and forms for the image module.
- Citations now use the blockquote element to enclose the text.
- Minor issue fixes in general page styling.
- Tab accessibility is improved for the search functionality.
- Patches contrib shariff fixing twitter popups and missing dependencies - 2881126.
- Moves the shariff2click functionality to the module depending on shariff.
- Fixes icon display and download block when in the sidebar.
- Image styles regeneration on media update.
- Updates the responsive image styles for media video and video upload view modes.
- Header only appears when there is something inside.
- Node view modes title and text fields have been trimmed.
- Fixed play/pause functionality for sliders.
- Add active trail classes for the menu.
- Removed install config for instagram and tweet, since its already part of lightning.
- Improved language block tab accessibility.

## [1.5.0] - 2017-09-08
### Added
- Embedded view modes for media to simplify paragraph display in the node edit form.
- New Relic project support for platform.
- Added a new translations updater service called degov_locale.updater.
- Added translation files for the degov_social_media_settings module.

### Changed
- Each share button works individually with the double-click sharing functionality.
- Removed the arrow icon when selected the search button in the menu.
- Preview view mode changes for media elements.
- Disabled autoplay by default for the video media type.
- Improvements to Behat testing.

### Fixed
- RSS feeds are now correctly overwritten to support content types and tag URLs.
- Display primary actions for the frontpage when degov_multilingual is enabled.
- Removed social media source field dependency from degov_media_video.
- Fixes image responsive styles on media for the search page.
- Removed title from blog default template.
- Views helper module filters media view modes based on chosen entity.

## [1.4.0] - 2017-09-01
### Added
- Added menu block for levels 4 and deeper to the second sidebar region.
- Added press-slider view mode to latest press view and updated styling accordingly.
- Added styling for Audio media type and changed the according templates.
- Added link to fontawesome beneath class input in menu items.
- Added degov_media_social_media_embed module.
- Added degov_social_media_settings module.
- Changed templates of media bundle video to support degov_social_media_settings.
- Changed page and header intro theme templates to support degov_social_media_settings.
- Referenced views now include a class of the rendered view mode selected.
- Added a new map style IT NRW map to the map paragraph.
- Added degov_scheduled_updates module to support scheduled content publishing.
- New view mode preview added for the some_embed media bundle.
- Added field_section to index and facet to search page.
- Added deGov multilingual module to handle multilingual frontpages and according templates.
- Added hoverIntent library to menu as additional UX improvement.
- Added new slideshow view mode for Node entity type to display content inside slideshow paragraph.
- Title attributes on action elements added to improve UX.
- New feature 'deGov - Restrict IP' added.
- New template full has been added for the deGov image module.
- New color variable brand-secondary added.
- Added VSM Search integration to regular search page.
- Added permission to update any media for role editor.
- Added view mode preview for media types, media views and styling.
- RSS feeds for content types and tags.

### Changed
- Block reference paragraph block field was changed to a block field type from the
  block_field module that has a widget configured as a block instance.
- Created a unified settings menu in the degov_common module under the path /admin/config/degov.
- Improved display and styling of latest press releases.
- Update basic media search to use preview view mode.
- External links open in a new tab and have an extra class in the links paragraph.
- Restrict the paragraph map to only include view modes that render out a map.
- Improved UX of the menu by leaving the menu open on hover and closing by outside click.
- Leaflet library is now added to composer as a dependency on the media address module.
- Latest press view now contains a slider block and the default content block.
- Scheduled updates drush command is now moved to the degov_scheduled_updates module.
- Scheduled updates are now handled with the field per content type and can target latest revision.
- Added support for social media settings in media video bundle preview view mode.
- Content type field is not processed with tokenizers and transliteration on search index.
- Allowed script tag for some_embed bundles.
- Changed 'ALT' field to mandatory for image media bundle.
- Slideshow paragraph now allows node reference and view reference paragraphs.
- Changed 'media--image--default' and 'media--image--usage' templates.
- Color variables correction.
- Removed thumbnail navigation from media gallery templates.
- Audio file fields in the audio media type are now optional.

### Fixed
- Breadcrumbs are now linking to their corresponding page.
- Gallery pages now have a correct working slider.
- Validation for taxonomy term search formatter route name.
- Corrected the label in media contact form.
- Corrected views row class on all content views.
- Navigation pagers styling are corrected.
- Main menu styling and hovering effects fixed.
- Submenu styling in the sidebar.
- Moved config for usage view modes of existing media bundles to the correct config/install folder.
- Accessibility improvements for tabs on webforms.
- Calendar popup fields have similar styling.
- Patch scheduled updates contrib module so no mandatory date is required.
- Styling for image caption and copyright in media image for entity and header slider.
- Columns in the main menu have been added.
- Margins and wrapper corrections for media gallery.
- Default icon added for unknown primary action buttons.

## [1.3.0] - 2017-08-25
### Added
- Fake 2-click sharing with shariff
- Added role 'usermanager'.
- Added print.css for print version
- Added view mode 'author' to 'media person', created 'media person author' template and 'view blog author' scss.
- Added view mode 'preview' to all media bundles
- Styled view mode preview for media bundles 'audio', 'video', 'image', 'gallery' and 'video_upload'

### Changed
- Changed view blog author title to 'autor' and selected view mode 'author'.
- Added role 'usermanager'.
- updated permissions for roles editor and manager.
- Image cropping is now required. See patch #17 https://www.drupal.org/node/2871137.
- Change the media reference paragraph widget to correctly render by view mode.

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
