## Contao Extensions, welche für GMK geschrieben worden sind.

Die Erweiterungen sind alle in vendor/markocupic abgelegt und werden in der root composer.json über den repositories key registriert.

```
{
    "type": "project",
    "require": {
        "contao/conflicts": "*@dev",
        "contao/listing-bundle": "4.9.*",
        "contao/manager-bundle": "4.9.*",
        "contao/news-bundle": "4.9.*",
        "markocupic/contao-article-class-select-bundle": "1.0.0",
        "markocupic/gmk-download-bundle": "1.0.0",
        "markocupic/gmk-generate-page-hook-bundle": "1.0.0",
        "markocupic/gmk-headline-bundle": "1.0.0",
        "markocupic/gmk-mitarbeiter-bundle": "1.0.0",
        "markocupic/gmk-news-bundle": "1.0.0",
        "markocupic/gmk-newsteaser-bundle": "1.0.0",
        "markocupic/gmk-referenzen-bundle": "1.0.0",
        "markocupic/social-images-extended-bundle": "1.0.0"
    },
    "repositories": [
        {
            "type": "path",
            "url": "vendor/markocupic/contao-article-class-select-bundle"
        },
        {
            "type": "path",
            "url": "vendor/markocupic/gmk-generate-page-hook-bundle"
        },
        {
            "type": "path",
            "url": "vendor/markocupic/gmk-headline-bundle"
        },
        {
            "type": "path",
            "url": "vendor/markocupic/gmk-mitarbeiter-bundle"
        },
        {
            "type": "path",
            "url": "vendor/markocupic/gmk-news-bundle"
        },
        {
            "type": "path",
            "url": "vendor/markocupic/gmk-newsteaser-bundle"
        },
        {
            "type": "path",
            "url": "vendor/markocupic/gmk-referenzen-bundle"
        },
        {
            "type": "path",
            "url": "vendor/markocupic/gmk-download-bundle"
        },
        {
            "type": "path",
            "url": "vendor/markocupic/social-images-extended-bundle"
        },
        {
            "type": "path",
            "url": "vendor/markocupic/portfoliotemp"
        }
    ]
}


```
