ITNRW Map module

This module is about the simplest way to get a ITNRW Map, or a link to a
ITNRW Map, displayed with your content. It simply provides a field formatter
for Drupal 8 text fields. With this formatter, you can enter a single-line
address that ITNRW Maps would recognize into a plain text field, such as:
   100 Madison Ave, New York, NY
And then on your Manage Display screen (or in Views field setup), you can choose
to display the field with an embedded iframe, a link to a --
map, or both; with or without the original address text.


To install and use:
- Upload/unzip to your Drupal 8 /modules directory (or /modules/contrib or whatever).
- Enable the module.
- Add a plain Text field to your content type. You probably should add some
  Help text to the field to explain that a one-line address that the module can
  recognize needs to be entered, and that the output will be formatted with a
  map (or a link or both, depending on how you are using this field).
- On the Manage Display screen, or when adding this field to Views, choose the
  provided mapping formatter.
- If desired, click the button to change the field display settings.

Note: There are no field validation steps in this module yet, and it just uses a
regular Text field. The display settings let you choose the size of the map,
the text for the map link, the map zoom level (applies to both embedded and
linked map), whether to display information about the address in a bubble, and
to turn on/off the various things you can display.
