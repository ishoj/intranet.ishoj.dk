api = 2
core = 7.x

;; OS2Web projects:

; OS2Web Modules

projects[os2web_base][type] = "module"
projects[os2web_base][download][type] = "git"
projects[os2web_base][download][branch] = "develop"
projects[os2web_base][download][url] = "https://github.com/OS2web/os2web_base.git"

projects[os2web_taxonomies][type] = "module"
projects[os2web_taxonomies][download][type] = "git"
projects[os2web_taxonomies][download][branch] = "develop"
projects[os2web_taxonomies][download][url] = "https://github.com/OS2web/os2web_taxonomies.git"

;; Contrib modules below:

; Libraries

; Contrib modules

; Features + related
projects[features][subdir] = "contrib"
projects[features][version] = "2.0-beta2"

projects[strongarm][subdir] = "contrib"
projects[strongarm][version] = "2.0"

; Panels

; Basic
# projects[ctools][subdir] = "contrib"
# projects[ctools][version] = "1.3"

projects[field_group][subdir] = "contrib"
projects[field_group][version] = "1.1"
; Patch to remove notices in badly stored features. TODO: add issue on d.o
; projects[field_group][patch][] = "patches/field_group-1.patch"

projects[webform][subdir] = "contrib"
projects[webform][version] = "3.18"
