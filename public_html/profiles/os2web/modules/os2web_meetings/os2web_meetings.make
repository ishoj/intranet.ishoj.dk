api = 2
core = 7.x

;; OS2Web projects:

; OS2Web Modules

projects[os2web_qbrick][type] = "module"
projects[os2web_qbrick][download][type] = "git"
projects[os2web_qbrick][download][branch] = "develop"
projects[os2web_qbrick][download][url] = "https://github.com/OS2web/os2web_qbrick.git"

projects[os2web_print_send_to_friend][type] = "module"
projects[os2web_print_send_to_friend][download][type] = "git"
projects[os2web_print_send_to_friend][download][branch] = "develop"
projects[os2web_print_send_to_friend][download][url] = "https://github.com/OS2web/os2web_print_send_to_friend.git"

;; Contrib modules below:

; Libraries

libraries[dompdf][download][type] = "git"
libraries[dompdf][download][url] = "https://github.com/dompdf/dompdf.git"
libraries[dompdf][download][revision] = "master"
libraries[dompdf][destination] = "modules/contrib/print"

; Contrib modules

; Features + related
projects[features][subdir] = "contrib"
projects[features][version] = "2.0-beta2"

projects[strongarm][subdir] = "contrib"
projects[strongarm][version] = "2.0"

; Panels
projects[panels][subdir] = "contrib"
projects[panels][version] = "3.3"


; Basic
# projects[ctools][subdir] = "contrib"
# projects[ctools][version] = "1.3"

projects[views][subdir] = "contrib"
projects[views][version] = "3.7"

projects[date][subdir] = "contrib"
projects[date][version] = "2.6"

projects[entityreference][subdir] = "contrib"
projects[entityreference][version] = "1.0"

projects[autocomplete_deluxe][subdir] = "contrib"
projects[autocomplete_deluxe][version] = "2.0-beta2"
projects[autocomplete_deluxe][patch][] = "http://drupal.org/files/autocomplete_deluxe-fix_truncated_terms-beta2-1754164-13.patch"

projects[better_exposed_filters][subdir] = "contrib"
projects[better_exposed_filters][version] = "3.0-beta3"

projects[computed_field][subdir] = "contrib"
projects[computed_field][version] = "1.0-beta1"

projects[ds][subdir] = "contrib"
projects[ds][version] = "2.2"

projects[expire][subdir] = "contrib"
projects[expire][version] = "1.0-beta1"
projects[expire][patch][] = "http://drupal.org/files/1668584-fix-undefined-index-language.patch"

projects[lightbox2][subdir] = "contrib"
projects[lightbox2][version] = "1.0-beta1"

projects[references][subdir] = "contrib"
projects[references][version] = "2.1"

projects[print][subdir] = "contrib"
projects[print][version] = "1.2"

projects[rules][subdir] = "contrib"
projects[rules][version] = "2.3"

projects[views_php][subdir] = "contrib"
projects[views_php][version] = "1.x-dev"
