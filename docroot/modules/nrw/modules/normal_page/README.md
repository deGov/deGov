# Normal Page

## Description

The normal page content type divides the node region into 3 separate regions.
Each region is able to add multiple paragraph items of different types.

The template implementation looks like following:

-----------------------------
|                           |
|       header region       |
-----------------------------
|       9/12      |   3/12  |
|                 |         |
|                 |         |
|     content     |  right  |
|     region      |  region |
|                 |         |
|                 |         |
-----------------------------

The `content region` will be expanded to be full width in case no content has been added to the `right region`.
Regions will be shown by their full width for every screen size lower than a medium screen.

A normal page also contains `title`, `subtitle` and `image` teaser fields.
These fields are shown for the teaser of a normal page.
With the `image` field having a fixed 3/12 ratio from medium screens and up.