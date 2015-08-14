OS2Web Help
==============================

Description
-----------
This module provides an help section for OS2web in admin/help/os2web_help.
This includes all help section for all os2web modules which are enabled.

Add documentation to this section by implementing the custom os2web_help hook used in os2web_help.module.
Here is an example of such an implementation:


    /**
     * Implements hook_os2web_help().
     */
    function MODULE_NAME_os2web_help($sections) {

      // Module specific documentation.
      $sections['module_name'] = t('<p>Your documentation here.</p>');

      return $sections;
    }

If your documentation is more advanced an could use its own page, consider to use the [drupal help](http://api.drupal.org/api/drupal/modules!help!help.api.php/function/hook_help/7) hook:

    /**
     * Implements hook_help().
     */
    function MODULE_NAME_help($path, $arg) {
      switch ($path) {
        case 'admin/help#module_name':
          return t('Your documentation here');
      }
    }

Dependencies
-----------

Installation
-----------
This module should reside in the modules directory of the installation,
most commonly profiles/os2web/modules/, but alternativly in sites/all/modules
(This could be for development purposes).

See https://github.com/syddjurs/os2web/wiki for further instructions.

This module can also be installed with drush make in your install profile.

Licence and copyright
---------------------
OS2Web is Copyright (c) 2012 Syddjurs Kommune, Denmark

OS2Web is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

OS2Web is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

Additional Info
---------------
This repository should be governed using Git Flow. for more information see
http://nvie.com/posts/a-successful-git-branching-model/

Note: This module is still dependant on modules in the full OS2Web suite
(https://github.com/OS2web/os2web), as the seperation of those are still WIP.
