# PDF Ink Coverage Extractor
![Check & fix styling](https://github.com/bureaupartners/pdf-ink-coverage-extractor/workflows/Check%20&%20fix%20styling/badge.svg?branch=master)
![Run Psalm](https://github.com/bureaupartners/pdf-ink-coverage-extractor/workflows/Psalm/badge.svg?branch=master)
![Run tests](https://github.com/bureaupartners/pdf-ink-coverage-extractor/workflows/Run%20tests/badge.svg?branch=master)

A simple package for extracting the ink coverage in a PDF file

## Installing / Getting started
First add bureaupartners/pdf-ink-coverage-extractor to your composer.json
```shell
composer require bureaupartners/pdf-ink-coverage-extractor
```
Then add the following code to your project
```php
use BureauPartners\InkCoverageExtractor\InkCoverageExtractor;

$ink_coverage = new InkCoverageExtractor('Document.pdf');
$ink_coverage->getCoverage(); // Returns all pages with ink coverage
```

## Contributing

If you'd like to contribute, please fork the repository and use a feature
branch. Pull requests are warmly welcome.

## Links
- Repository: https://github.com/bureaupartners/pdf-ink-coverage-extractor
- Issue tracker: https://github.com/bureaupartners/pdf-ink-coverage-extractor/issues


## Licensing
The code in this project is licensed under MIT license.
