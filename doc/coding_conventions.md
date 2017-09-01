# Coding Conventions

## Naming conventions
Naming convention is about names that are set in the UI with Drupal.

Names should describe the functionality such as 'blog', 'links', or 'reference_list'.

Seperate double words with a underscore ('_'), use 'reference_list' not 'referencelist'.

ACHTUNG: This also concerns translations.

## Modules
Every module we create must be prefixed with degov, followed by entity-type (if applicable), followed by name.

Valid module names for entities are:

* `degov_paragraph_citation`
* `degov_media_citation`
* `degov_node_blog`
* `degov_node_landing_page`
* `degov_password_policy`

Custom modules are also prefixed with degov followed by a descriptive name.

Valid module names for custom modules are:

* `degov_content_types_shared_fields`
* `degov_my_custom_module`

## Folders ("repos")

> Every JIRA issue will say to which "repo" (meaning folder or level) the module/feature should go. If not, ask the responsible.

Type|Project|Folder|Level
----|---|---|---
modules|nrwGov|sites/all/modules/nrwgov/modules|	deGov==nrwGov level
features|nrwGov|sites/all/modules/nrwgov/feature|deGov==nrwGov level
theme|nrwGov|themes/nrwgov/nrwgov_base_theme	|deGov==nrwGov level
modules|nrw|sites/all/modules/nrw/modules|	the NRW level
features|nrw|sites/all/modules/nrw/features	|the NRW level
theme|nrw|themes/nrwgov/nrw_base_theme|the NRW level
modules|MIK|sites/all/modules/custom/modules	|MIK level
features|MIK|sites/all/modules/custom/features	|MIK level
theme|MIK|themes/custom/mik_theme	|MIK level

## INFO File
Every's module .info.yml file needs to include:

* **module name**, e.g. "deGov - ParagraphFAQ" → so: <deGov|NRW|MIK> - <Paragraph|Media|Taxonomie|Inhalt> <name>
* **package name**, e.g. MIK, NRW, deGov → depending on the module repository (custom, nrw, nrwGov==deGov)
* **description** a useful description of the module, ideally in german

## Entities
### Bundles
Entity bundles are not prefixed, because they are automatically prefixed in css classes and database tables.

Valid names are

* image ← paragraph bundle
* image ← media bundle
* blog ← node bundle

ACHTUNG: Choose short bundle names, to keep file names short. Do not use 'press_release' use 'press' instead.

### Fields / Paths
Fields must be unique per bundle and cannot be reused across bundles.

Therefore fields are prefixed with the bundle name.

Valid names are:

* image_title ← in media/image
* image_image ← media/image
* image_copyright ← in media/image
* image_media ← in paragraph/image
* image_tite ← in paragraph/image
* page_text ← in node/page

The path for files is always

* ENTITY / BUNDLE / FIELD_TYPE /*

Valid path names are:

* media/document/file
* node/press/image
* node/press/file

ACHTUNG: If filename is too long shorten last word in a sensible way. Shorten `'field_press_sidebar_right_paragraphs'` to `'field_press_sidebar_right_para'`

## Admin UI
The Admin UI is of great importance for the authoring experience. Few Rules:

### field order for content types
* Title
* Teaser Title
* Teaser Text
* Teaser Image 
* Custom fields (custom to this content type)
* Paragraphs
	* 	header
	*  content	
	*  sidebar right

### field order for paragraphs
* Title
* Subtitle
* custom fields


## HTML structure
A page has only one **H1**

Pages are structured using paragraphs. If a **paragraph** has a **title** or a title paragraph is used it is rendered as **H2**.

If content in paragraphs have titles (such as views), these are rendered as **H3**.

In views we always use view modes, never fields.

Entities always have two view modes:

* Default
* Teaser
* 
In **viewmode Teaser** titles are **always rendered as H3** (this is done in the template not in the display configuration).

In **wysiwyg** editing H2 and H3, .... H6 are allowed.

## Code conventions backend

Module code must meet the Drupal coding standards:

* See Drupal coding standards: [https://www.drupal.org/docs/develop/standards/coding-standards](https://www.drupal.org/docs/develop/standards/coding-standards)
* See Drupal OOP coding standards: [https://www.drupal.org/docs/develop/coding-standards/object-oriented-code
](https://www.drupal.org/docs/develop/coding-standards/object-oriented-code)
* See Drupal documentation standards: [https://www.drupal.org/docs/develop/coding-standards/api-documentation-and-comment-standards](https://www.drupal.org/docs/develop/coding-standards/api-documentation-and-comment-standards)

## Quality Assurance (QA)
Before new code is merged into the development branch it will be checked manually and automatically with [Coder sniffer](https://www.drupal.org/node/1419980)

## Code conventions frontend
### Quick tips
**Tips for templates and selectors**

#### Templates
* We create our **own templates** for all bundles of **nodes**, **media**, and **paragraphs**. With this we control the selectors.
* We do not create templates for fields.
* For **styling we only use our own selectors** except for field specific styling.

#### Selectors
Only use 3 types of selectors

* Component
* Variant
* Sub-objects

We do not use variants of sub-objects.

```
 /* BEGIN EXAMPLE */
 /* Component Rules */
 .component-name
 .component-name--variant
 .component-name__sub-object
 .component-name__sub-object--variant  /* We do not use this */
   /* END EXAMPLE */
```

* Styling rules always appear in the order like in the example above
* We **never use IDs for styling**, IDs are only for JS
* **State classes** are always prefixed with 'is'

```
   /* BEGIN EXAMPLE */
   .is-active
   /* END EXAMPLE */
```

* We want to produce as little scss code as possible, therefore we want to style as generic as possible, therefore we **do not** want to **nest scss selectors deeper that 2 levels** with named selectors. If you run into a situation in which different selectors are needed, we change the template.

```
   /* BEGIN EXAMPLE */
   /* You can do this */
   .paragraph {
     field-title {
       font-weight: bold;
     }
   }
   /* You can also do this */
   .paragraph {
     field-content {
       /* The selectors below are named */
       ul{
         margin: 1em;
         li {
           padding: 1em
         }
       }
     }
   }
   /* But you cannot do this */
   .page {
     .page-header {
       .menu-wrapper {
         .menu-item {
           cursonr: pointer;
         }
       }
     } 
   }
   /* END EXAMPLE */
```

## General info
deGov is a modular software. All modules define their own templates.

For NRW the modules are extended to reflect the layout of the NRW design ([http://land.nrw](http://land.nrw), [http://mais.nrw](http://mais.nrw)). Sitebuilding is done using entities with viewmodes. Therefore all entities need viewmodes and coresponding templates. Besides defining their own templates, modules also define their own JS. However, modules do not define their own CSS, this is handeled in the theme.

Although these templates can be overridden in the theme, this should not be done in this project. Only general layout modules (page, node, or fields) should be implemented in the theme.

The following breakpoints will be used for the project: 520px / 960px compare [Breakpoints](breakpoints.md).

The following convetions is for templates (both module and theme):

* The template must define a sensible layout for the defined breakpoints using [Bootstraps grid system](http://getbootstrap.com/css/#grid) classes, that is: .col-xs-, .col-sm-, .col-md-, .col-lg-
* In addition the HTML-Elements must be adressable with classess using [BEM syntax](http://getbem.com/introduction/) in the [Drupal way](https://www.drupal.org/docs/develop/standards/css/css-architecture-for-drupal-8#best-practices).
* JS must follow Drupal JS coding standards: [https://www.drupal.org/docs/develop/standards/javascript/javascript-coding-standards](https://www.drupal.org/docs/develop/standards/javascript/javascript-coding-standards
)
* SCSS code must follow Drupal CSS standards: [https://www.drupal.org/docs/develop/standards/css/css-coding-standards](https://www.drupal.org/docs/develop/standards/css/css-coding-standards), especially [https://www.drupal.org/docs/develop/standards/css/css-architecture-for-drupal-8#best-practices](https://www.drupal.org/docs/develop/standards/css/css-architecture-for-drupal-8#best-practices)
* Generally Drupal theming standards must be followed: [https://www.drupal.org/docs/7/theming/tools-and-best-practices/theme-coding-conventions](https://www.drupal.org/docs/7/theming/tools-and-best-practices/theme-coding-conventions)

Here is an example for a template:
```
<article class="blogarticle col-xs-12 col-md-6">
  <div class="blogarticle__header">
    <div class="blogarticle__header-tags">
      {{ content.field_blogarticle_tags }}:
      {{ content.field_blogarticle_blog_type_ref }}
    </div>
    <div class="blogarticle__header-info">
      {% set author = author_name|striptags %}
      {% set author_date = content.field_blogarticle_datetime|render %}
      <div class="author">
        <div class="author__name">{% trans %} From {{ author }} {% endtrans %}</div>
        <div class="author__date">{% trans %} {{ author_date }} {% endtrans %}</div>
      </div>
    </div>
  </div>
  <div class="blogarticle__content content">
    {{ content.field_blogarticle_subtitle }}
    <h1>{{ label }}</h1>
    {{ content.field_blogarticle_teaser_text }}
    {{ content.field_blogarticle_image }}
    {{ content.field_blogarticle_contents }}
    <div class="shariff_share">
      <div class="shariff_share__label">{% trans %}Share article:{% endtrans %}</div>
      <div class="shariff_share__content">{{ content.shariff_field }}</div>
    </div>
  </div>
</article>
```

## Quality Assurance (QA)
Before new code is merged into the development branch the following checks will be checked manually and automatically with [Coder sniffer](https://www.drupal.org/node/1419980):

* HTML-Elements in templates
* Coresponding scss rules
* JS-syntax

## Translations
### User interface translation
First of all we need to follow the guidelines from here [https://www.drupal.org/docs/8/api/translation-api/overview](https://www.drupal.org/docs/8/api/translation-api/overview). Everywhere in PHP code it is allowed to use translation function `t()` or the method in the current class `self::t()` / `$this→t()` that takes the string parameter and tries to match it with the translation from the database. The string parameter that is passed to this function/method must be in English language. It is also possible to translate the strings in Object Annotations and inside the YML files. Please refer to the guideline for proper implementation.

Module developers should include the translation for the module in the module structure: inside the translations folder. To make it possible the one needs to follow the guidelines from here [https://api.drupal.org/api/drupal/core%21modules%21locale%21locale.api.php/group/interface_translation_properties/8.3.x](https://api.drupal.org/api/drupal/core%21modules%21locale%21locale.api.php/group/interface_translation_properties/8.3.x) and have the translation settings in .info.yml file like this:

```
name: 'Custom module' 
type: module

version: '8.x-1.0'
core: 8.x 
project: 'custom_module'
```

As we don't know the structure of the modules folder and the module could be placed anywhere on the code, we need to implement the hook_locale_translation_projects_alter to pass 'interface translation server pattern' that we can't do in the yml file. So in custom_module.module file place this code:

```
function custom_module_locale_translation_projects_alter(&$projects) {
 // The translations are located at a custom translation sever.
 $projects['custom_module'] = [
 'info' => [
 'interface translation project' => 'custom_module',
 'interface translation server pattern' => drupal_get_path('module', 'custom_module').'/translations/%language.po',
 ],
 ];
}
```

here %language stands for the language code such as "de" for German or "pt-pt" for Portuguese Portugal.

Don't forget that 'custom_module' should be replaced with your module name. 

When implementing this approach every call to update translations will trigger the module translation update. During the installation the last step is the translation update, so the installed modules will provide the translations at this time.

To import the translations use the following drush command:

`drush locale-update && drush cr`

To check the status of the translation use the following command:

`drush locale-check`

To extract the translation strings from the module code and generate the .po file the developer can use the following steps:

1. Use this module [https://github.com/kgaut/drupal-potx](https://github.com/kgaut/drupal-potx) to extract the strings from the module code. Do not use --include parameter from the example on Github, use the following syntax:
`drush potx single --modules=custom_module --api=8` 
It will create general.pot file in the Drupal root. This file should be edit further with POEdit.

2. use POEdit Application to provide translations [https://poedit.net/download](https://poedit.net/download)

Path prefix is set as language negotiation in deGov by default. Adding custom language will result in the same behaviour as adding English.

### Content translation
Content will not be translated it just should be the possibility to create the nodes with the reference to the language. It means the pages would be localised only. The localisation doesn't work out of the box for any of the entity types. This should be enabled on the node bundle edit form. On the "Language settings" tab the checkbox "Show language selector on create and edit pages" should be checked.

### Configuration translation
By default the language of the site is German, so after adding more languages the configuration (field labels, module settings) MUST be translated from German to other language. Every YML file that contains configuration entity export information has langcode property. When exporting and importing configuration please check this property. If you enable the Configuration Translation it will do it for you.

The main language of the configuration would be German, but the machine names MUST be in English.