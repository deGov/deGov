# Entity types and viewmodes

In deGov **nodes** (content types) are used for pages. Pages have a URL and are not meant to be re-usable entities except through references and views.

In nodes we use **paragraphs** (paragraph entities). These 'live' only inside the node, this means if a node is deleted the associated paragraphs are also deleted.

For re-usable content we use **media**. In deGov media is everything that is used on multiple pages. Examples are images, videos, slideshow, but also citations, adressess, person, etc.

## Media
All media bundles have the viewmodes

* **Default**
* **Preview**
* **Search**
* (Usage) ← Will probably be dismissed
 
Media entities can define more viewmodes. When a media entity is referenced, the viewmode can be selected.

## Viewmode Default
The default viewmode is used for displaying the media, if no other viewmode is selected. This is the case when the media entity is acessed directly.

## Viewmode Preview (Vorschau)
The preview viewmode is for all cases in which the entity should be previewed. These are:

* In views
* In search (mediathek)

## Adresse
### Default Map
This viewmode displayes a styled Google map, it can be used, when a media entity is placed using the media reference paragraph. It can be selected when referencing a media from a paragraph.

### OSM Map
This viewmode displayes a styled OSM map, it can be used, when a media entity is placed using the media reference paragraph. It can be selected when referencing a media from a paragraph.

## Audio
No additional viewmodes.

## Bildergalerie
No additional viewmodes.

## Citation
No additional viewmodes.

## Dokument
### Vorschaubild

### Embedded

## Image
### Vorschaubild

### Embedded

### Other

* Slider main (16:9)
* Teaser landscape (2:1)
* Teaser landscape small (8:3)
* Teaser opinion (4:1)
* Teaser squared (1:1)
* These are used in XXX.

## Instagram
No additional viewmodes

## Kontakt
No additional viewmodes

## Person
### Autor

## Tweet
No additional viewmodes

## Video
No additional viewmodes

## Video Upload
No additional viewmodes