..  include:: /Includes.rst.txt

..  _known-problems:

==============
Known problems
==============

This TYPO3 extension uses best practice and well known mechanisms to modify the
TYPO3 instance. No known problems. But be aware of following things.

.. tip::

    A professional TYPO3 instance is often customized exactly to the needs of an
    TYPO3 backend user. Check your own adoptions and customizations in your
    sitepackage and used extensions.

Modified TCA outside this TYPO3 extension
=========================================

This extension does not offer any checks if you modified the TCA of fe_users. If
the backend forms while editing frontend users in the TYPO3 backend not shown as
in the screenshots or as described check your existing modifications and/or
configurations on `fe_users` table.

This can include following:

*  Modifications via Page TSconfig (via PHP, TSconfig in pages, included Page
   TSconfig files in pages, Page TSconfig in your sitepackage, Page TSConfig in
   any installed 3rd-party TYPO3 extension
*  Modifications via TCA/Overrides via `<any3rdPartyExt>/Configuration/TCA/...`
*  Modifications via TCA/Overrides via
   `<yourSitepackageExt>/Configuration/TCA/...`
*  Modifications of your TCA via hooks or PSR-14 events
*  Modifications of your TCA via FormDataProviders
*  Modifications of your TCA via any not common override mechanism

Check also for modifications like:

*  Does any Extension modify the type of `fe_users.username`?
*  Does any Extension modify the eval options of `fe_users.username`?
*  Does any Extension modify the type of `fe_users.email`?
*  Does any Extension modify the eval options of `fe_users.email`?
*  Does any Extension modify the showitem config of any `fe_users` type in a way
   that it modifies in a primitive/hard way?
*  Does any Extension uses PSR-14 events or hooks which are stopping the
   execution of any events or hooks used in this extension?

Deactivated/Removed methods of this extension by other extensions
=================================================================

This extension does not offer any checks if any of the used mechanisms in this
TYPO3 extension are overridden/disabled/modified (FormDataProvider, DataHandler
hooks, Node Element Registration)

Please visit the project's GIT repository, if you think there's still a bug or a
missing feature.

Find a list of `open issues on Github
<https://github.com/josefglatz/sync-feusers-username-to-email/issues>`__.
