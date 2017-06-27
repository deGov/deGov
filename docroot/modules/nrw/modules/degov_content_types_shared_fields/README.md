# Content Types Shared Fields

## Description

This module contains all shared field storages for all content types.

## Why?

Uninstalling a feature/module that uses reusable fields will throw warnings on those shared fields.

## Implementation

A field configuration will exist out of a `field.field` and `field.storage` YAML file. In case you will use this field
as a reusable field in other entities, move the `field.storage` YAML file into this modules `config/install` directory.

## Important note!

Always make sure you have the `enforced module` lines included in the YAML configuration file of the field.