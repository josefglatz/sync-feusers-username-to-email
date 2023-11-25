..  include:: /Includes.rst.txt
..  index:: Configuration
..  _configuration-bestpracticeexample:

=====================
Best Practice Example
=====================

How such a website user configuration could look like in a real project.

This example targets a small frontend user area for partners to download
product sheets and internal monthly product update brochure downloads. There is
only one area for all of them. No need to add more than one website usergroup.

The users for those partner logins are maintained by the TYPO3 backend editor.
There is no frontend registration or any edit my profile form for website users.

The shown fields of website users in the backend are limited, to keep an good
overview of the partner logins. The backend editor should never feel
overwhelmed when creating/editing website users.

All fields of a website user record are defined with the client. Also the most
important fields should be shown right in the listing of website users.

Step by Step
============

.. rst-class:: bignums-xxl

#. Define the website user fields you need in your project

   It's not likely that all fields of a website user record have to be used in a
   real world website.

   Lets define the following fields: `username`, `password`, `usergroup`,
   `company`, `first_name`, `last_name`, `email`, `disable`, `starttime`,
   `endtime`, `description`.

   Match the fields with your customer needs! We will make many of them
   mandatory later.

#. Now limit the previously defined list of fields in your TYPO3 instance

   You have multiple ways to do this based on your needs! You can enable the
   fields for your non-admin backend users in the respective usergroup of them.
   But then an admin backend user will still see all other fields, which can be
   reduce the UX of an admin backend user.

   I recommend hiding not defined fields via
   :ref:`Page TSconfig <t3tsconfig:setting-page-tsconfig>` for all backend
   users. If you're not that TypoScript guy, just write your FormDataProvider to
   limit the fields (like some features of this extension is built on).

   Another good option is to overwrite the `showitem` configuration of table
   `fe_users` in your sitepackage extension via `TCA/Overrides/fe_users.php`.
   You can define which fields or palettes are in which register by using this
   method. This can be a real UX benefit! And you're able to create new
   fitting palettes.

   I highly recommend using a FormDataProvider over TSconfig or `TCA/Overrides`
   in some scenarios, but this depends on what a project needs.

   Do not forget: you are limited in `what you can override with TSconfig <https://github.com/typo3/typo3/blob/989d34bed6ad3136a40dca072d24def24e262374/typo3/sysext/backend/Classes/Form/Utility/FormEngineUtility.php#L46>`__

#. Now define default values when creating new website users

   We have only one website usergroup. Just add this per
   :ref:`Page TSconfig <t3tsconfig:setting-page-tsconfig>` using `TCAdefaults`
   mechanisms. The one-liner :typoscript:`TCAdefaults.fe_users.usergroup = 1`
   should work if your usergroup has UID 1.

#. Now define all mandatory fields

   It is super cool to improve the backend form for creating/editing website
   users! But honestly: you often asked yourself why you have limited the fields
   but no or not every backend user fills the defined fields.

   Therefore, work with your client to identify the fields that are helpful for
   maintenance and overview in step 1. Mention that, at a later stage, emails
   can also be sent to website users right from the TYPO3 backend if this
   requirement grows. It is then a great advantage if the easy-to-maintain
   fields are already filled.

   Also, mention that a backend user can thus navigate to the record for editing
   in the TYPO3 backend through the search function (You can open the live
   search by pressing the :kbd:`Ctrl` + :kbd:`K` or :kbd:`Cmd` + :kbd:`K`
   keystroke) using first name, company names, etc.

   In this example following fields are set to mandatory: `username`,
   `password`, `usergroup`, `company`, `first_name`, `last_name`. There are
   often scenarios in real projects where it makes sense to make all defined
   fields required/mandatory except for fields for notes like the field
   `description`.

   You make a field mandatory by using the `required` TCA property
   (:ref:`See docs of property <t3tca:tca_property_required>`). Read also the
   according changes in TYPO3 12.0 of
   :doc:`how to set fields required <ext_core:Changelog/12.0/Feature-97035-UtilizeRequiredDirectlyInTCAFieldConfiguration>`.

#. Lets further improve the list module view

   In our example the most important field next to `username` (=email) is the
   field `company`. Lets add this next to the email in the list module view by
   adopting the TCA of `fe_users` `ctrl` config section.

   See :ref:`ctrl - label_alt <t3tca:ctrl-reference-label-alt>` and
   :ref:`ctrl - label_alt_force <t3tca:ctrl-reference-label-alt-force>` in
   TYPO3's official TCA documentation.


Checkout a possible result of this example
==========================================

..  figure:: /Images/screencast-sync_feusers_username_to_email-best_practice_example01-001.gif
    :class: with-shadow
    :alt: Animated screencast of TYPO3 backend showing the integration of this best practice example
    :width: 100%

    Described working example without modifying TCA `showitem` configuration. It
    takes just a few minutes to get this result!
