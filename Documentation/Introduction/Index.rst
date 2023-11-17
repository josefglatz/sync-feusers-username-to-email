..  include:: /Includes.rst.txt

..  _introduction:

============
Introduction
============

This chapter gives you a basic introduction about the TYPO3 CMS extension
"*josefglatz/sync-feusers-username-to-email*".

What does it do?
================

This extension implements helpers to keep the field `email` in sync with the
field `username` for website user records in the TYPO3 backend.

**Best practices from the scratch**

- Based on best practice modifications like FormDataProvider, DataHandler hooks,
  TCA/Overrides and Symfony Console Commands
- Easy to use & understand for editors
- Easy to configure "just install and use it"

.. tip::

    A good reason to use this extension is when you just want to have website
    user logins with email addresses instead of any username-string!

..  note::

    But keep in mind, that you can also extend/override the authentication
    process of your TYPO3 instance. By default `username` and `password` are
    used in the TYPO3 core.

    Think about writing your own authentication service if you have any scenario
    where it makes sense to maintain a `username` and an `email` of website
    user records in your TYPO3 instance.

..  _screenshots:

Screenshots
===========

Creating a new website user record
----------------------------------

How the TYPO3 Backend of the editing form look like when creating a new website
user record after installation.

Field username is improved for email address values
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

How the field `username` of the editing form look like when creating a new or
editing an existing website user record after installation.

Field email is hidden
~~~~~~~~~~~~~~~~~~~~~

The field `email` is completely hidden in the editing form when creating a new
website user record.


Editing an existing website user record
---------------------------------------

How the field `email` of the editing form look like when editing an existing
website user record after installation.
