Gallery module
==============

Installation
------------
manual install direct to modules directory
```bash
git clone https://github.com/geniv/nette-module-gallery.git app/modules/GalleryModule
```
must by install db from sql files

SQL order install
-----------------
1) prefix_gallery.sql
2) prefix_gallery_item.sql
3) prefix_gallery_item_has_locale.sql
4) prefix_gallery_has_locale.sql

Include in application
----------------------
neon configure:
```neon
# gallery module
galleryModule:
    tablePrefix: %tablePrefix%
    gallery:
        pathToImage: "www/files/image/gallery/"
```

neon configure extension:
```neon
extensions:
    galleryModule: GalleryModule\Bridges\Nette\Extension
```

header menu:
```latte
<li n:class="$presenter->isLinkCurrent(':Gallery:*') ? active"><a n:href=":Gallery:">{_'header-gallery'}</a></li>
```
