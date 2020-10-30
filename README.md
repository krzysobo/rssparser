RssParser
================

[![License](http://img.shields.io/badge/license-MIT-lightgrey.svg)](https://github.com/krzysobo/rssparser/blob/master/LICENSE)


:package_description

- [Installation](#installation)
- [Usage](#usage)
- [Testing](#testing)
- [Credits](#credits)
- [License](#license)


Installation
------------

Download the code and unpack to a directory you want.

Being in the project root, in the command line please execute:
``` bash
$ composer update
```
To install your dependencies using composer.

In the src directory, find the file config.yml.dist and copy it as config.yml.
Set your to logs in this file, for example /usr/local/var/log/rssparser.log

Example config.yml file (also attached in the repo):
``` yaml
log_path: "/usr/local/var/log/rssparser.log"
```

Usage
-----

Go to the project root (the level above src and vendor )
To overwrite the target file in a case it already exists:
``` bash
$ php src/console.php dev:basic {feed_url} {output_file_path} 
```

To append the data to the target file in a case it already exists:
``` bash
$ php src/console.php dev:extended {feed_url} {output_file_path} 
```

Example:
``` bash
$php src/console.php dev:basic http://feeds.bbci.co.uk/news/rss.xml output.csv -v
```

Testing
-------

``` bash
$ phpunit
```


Credits
-------

- [Krzysztof Sobolewski](https://github.com/krzysobo)


License
-------

The MIT License (MIT). Please see [License File](https://github.com/krzysobo/rssparser/blob/master/LICENSE) for more information.