# degov

This is the base theme for the deGov Drupal distribution. It can be extended to build a custom theme for any deGov installation.

It uses a watch system built on _gulp_ to run build and copy tasks and trigger livereloading.


#### How to install

# (Note: you have to be in the theme directory for this to work)
$ npm install


#### Common errors

**Error:** `ReferenceError: Set is not defined (…)`  
**Solution:** You have a version of node which does not support the new Set object. To get that you need to update the installed node version. Change to the root of the theme and call `./tools/update-node.sh`

**Error:** `Error: Missing binding (…) Node Sass could not find a binding for your current environment (…)`  
**Solution:** Your version of node has changed, this means you need an updated node-sass binary. You can get that by calling `npm rebuild node-sass`


#### Development tasks

To run the development task, run `npm start`


#### Directory structure changes

Writing frontend code happens in the `source` directory (Previously `src`) – code gets compiled/copied to `public` from there. (__Never work in `public`!__)

Assets referenced in CSS should be relative, so when everything is compiled and copied the urls work just the same from within the `./public` directory.

#### Modules/libraries

###### JS libraries
We don't use bower anymore. Third party modules are now added exclusively as _npm_ modules.

We can include JS libs by using the node style `require('mymodulename')`. Our javascript build tool scans our _entry_ file (`main.js`) and parses any `require` statements, then it scans those files and their dependencies building a _dependency graph_ in the process. Then it

The bootstrap JS file is included via CDN to optimise page loading speed so you don't have to worry about that. Also jQuery is included on any page of the website by default.

Example of adding the _imagesloaded_ module:
```bash
# Install the module and save it as a dev dependency
$ npm install imagesloaded --save-dev
# start development task …
$ npm start
```

Then in our `./source/js/main.js`:
```javascript
const imagesLoaded = require('imagesloaded');

// the library is not automatically added as a jQuery plugin
// since it can also be used as a standalone library.
// To be able to use it as a plugin we have to do this:
// @see http://imagesloaded.desandro.com/#webpack
imagesLoaded.makeJQueryPlugin(window.jQuery);
```

###### SASS libraries
SASS files can be included in a similiar manner (if they have _eyeglass_ support) via `@import "mymodulename";`. (Or if they don't support eyeglass relatively `@import "../../../node_modules/mymodule/mymodulestyle.scss";`)