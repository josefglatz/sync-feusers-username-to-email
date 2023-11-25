..  include:: /Includes.rst.txt

..  _introduction:

============
Introduction
============

This chapter gives you a basic introduction about the TYPO3 CMS extension
"*josefglatz/sync-feusers-username-to-email*".

What does it do?
================

.. rst-class:: bignums-xxl

#. This extension implements helpers to keep the field `email` in sync with the
   field `username` for website user records in the TYPO3 backend.

#. In addition to that a command :bash:`fe_users:sync-username-to-email` is added
   and can be executed anytime with the :ref:`TYPO3 CLI <t3coreapi:cli-mode>` to
   update all `fe_users` records.

#. The UX while creating a new website record is slightly improved

   The field `lastlogin` is hidden as it doesn't provide any useful content.


Best practices from the scratch
-------------------------------

- Based on best practice modifications like FormDataProvider, DataHandler hooks,
  TCA/Overrides and Symfony Console Commands
- Easy to use & understand for editors
- Easy to configure "just install and use it"

Why?
====
.. tip::

    A good reason to use this extension is when you just want to have website
    user logins with email addresses instead of any username-string!

..  note::

    But keep in mind, that you can also extend/override the authentication
    process of your TYPO3 instance. By default `username` and `password` are
    used in the TYPO3 core.

    Think about writing your own authentication service if you have any scenario
    where it makes sense to maintain a `username` and a different `email` of
    website user records in your TYPO3 instance when you want a login by email
    as username in the authentication process. You will have to adopt the `eval`
    for `fe_users.email` by your own!

..  _screenshots:

Screenshots
===========

Creating a new website user record
----------------------------------

How the TYPO3 Backend of the editing form look like when creating a new website
user record after installation of this TYPO3 extension.

..  figure:: /Images/screenshot-sync_feusers_username_to_email-newrecord.png
    :class: with-shadow
    :alt: Screenshot of TYPO3 backend showing the form for creating a new website user record
    :width: 100%

    Improved TCA for editors. How the field `username` of the editing form look
    like when creating a new or editing an existing website user record after
    installation. Not shown in the screenshot: The field `email` is hidden when
    creating a new website user to improve the UX.


Editing an existing website user record
---------------------------------------

..  figure:: /Images/screenshot-sync_feusers_username_to_email-edit-existing-record.png
    :class: with-shadow
    :alt: Screenshot of TYPO3 backend showing the form for editing an existing website user record. The fields username and email are highlighted to show the visual differences after installing this extension.
    :width: 100%

    How the field `email` of the editing form look like when editing an existing
    website user record after installation.
