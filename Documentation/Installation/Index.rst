..  include:: /Includes.rst.txt

..  _installation:

============
Installation
============

The extension needs to be installed as any other extension of TYPO3 CMS. Get the
extension by one of the following methods:

#. **Use composer**: Run

   ..  code-block:: bash

       composer require josefglatz/sync-feusers-username-to-email


   in your TYPO3 installation.

#. **Get it from the Extension Manager:** Switch to the module
   :guilabel:`Admin Tools > Extensions`. Switch to :guilabel:`Get Extensions` and
   search for the extension key `sync_feusers_username_to_email` and import the

   extension from the repository.

#. **Get it from typo3.org:** You can always get current version from `TER`_
   by downloading the zip version. Upload the file afterwards in the Extension
   Manager.

.. _TER: https://extensions.typo3.org/extension/sync_feusers_username_to_email/

Compatibility
-------------

Ensure the compatibility of the extension with your TYPO3 installation by
considering this compatibility matrix:

=========== =========== =========== ======================================
  Ext        TYPO3       PHP         Support / Development
=========== =========== =========== ======================================
  dev-main   11 - 12     8.2 - 8.2   unstable development branch
  1          11 - 12     8.2 - 8.2   features, bugfixes, security updates
=========== =========== =========== ======================================



This project uses `semantic versioning <https://semver.org/>`_, which means that

*  **bugfix updates** (e.g. 1.0.0 => 1.0.1) just include small bugfixes or
   security relevant stuff without breaking changes,
*  **minor updates** (e.g. 1.0.0 => 1.1.0) include new features and smaller
   tasks without breaking changes and
*  **major updates** (e.g. 1.0.0 => 2.0.0) contain breaking changes which can be
   refactorings, features or bugfixes.
