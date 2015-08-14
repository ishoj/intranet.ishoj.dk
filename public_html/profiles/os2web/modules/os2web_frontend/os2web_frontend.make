api = 2
core = 7.x

;; OS2Web projects:

; OS2Web Modules

;; Contrib modules below:

; Libraries

libraries[qtip][download][type] = "get"
libraries[qtip][download][url] = "https://raw.github.com/bellcom/qTip1/master/1.0.0-rc3/jquery.qtip-1.0.0-rc3.min.js"
libraries[qtip][directory_name] = "qtip"
libraries[qtip][destination] = "libraries"

libraries[superfish][download][type] = "git"
libraries[superfish][download][url] = "https://github.com/mehrpadin/Superfish-for-Drupal.git"
libraries[superfish][download][revision] = "master"
libraries[superfish][destination] = "libraries"

; Contrib modules

; Basic

# projects[ctools][subdir] = "contrib"
# projects[ctools][version] = "1.3"

projects[features][subdir] = "contrib"
projects[features][version] = "2.0-beta2"

projects[strongarm][subdir] = "contrib"
projects[strongarm][version] = "2.0"

projects[menu][subdir] = "contrib"
projects[menu][version] = "1.4"

projects[menu_block][subdir] = "contrib"
projects[menu_block][version] = "2.3"

projects[nice_menus][subdir] = "contrib"
projects[nice_menus][version] = "2.1"

projects[menu_minipanels][subdir] = "contrib"
projects[menu_minipanels][version] = "1.0-rc6"

projects[delta][subdir] = "contrib"
projects[delta][version] = "3.0-beta11"

projects[context][subdir] = "contrib"
projects[context][version] = "3.0-beta6"

projects[views][subdir] = "contrib"
projects[views][version] = "3.7"

projects[superfish][subdir] = "contrib"
projects[superfish][version] = "1.8"

projects[menu_position][subdir] = "contrib"
projects[menu_position][version] = "1.1"

projects[media][subdir] = "contrib"
projects[media][version] = "2.0-unstable7"
projects[media][patch][] = "http://drupal.org/files/media-media_browser-preview_javascript_incompatibility-1743040.patch"
