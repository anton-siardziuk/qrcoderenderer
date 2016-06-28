QR Code Renderer
================

Run
---
```
composer install
php -S localhost:8080 -t public public/index.php
```

Get QR Code
-----------
go to http://localhost:8080/index.php?t=text&h=500&w=500

Design problems
---------------
I would change proposed design in this way

1. Introduce new Modules (namespaces) and classes, so `QrCode` module does not depend on `GoogleChartsRenderer`,
    and `GoogleChartsRenderer` does not depend on `GuzzleHttpClient`:
  * namespace `QrCode`
    * class `QrCode`
    * interface `Renderer`
    * class `RenderingError`
  * namespace `Renderer`
    * class `GoogleChartsRenderer`
    * interface `HttpClient`
    * class `HttpError`
  * namespace `httpClient`
        * class `GuzzleHttpClient`

2. Make `HttpClient` constructor argument of `GoogleChartsRenderer` required: again,
    there is no need to depend on `GuzzleHttpClient`

3. `QrCode` is a value object. Value objects should be immutable and serializable. So there shouldn't be `setRenderer()`
    method: we should use double dispatch here like that:
    ```php
    $qrCode = new QrCode(/*...*/);
    $renderer = /*...*/
    $data = $qrCode->generate($renderer);
    ```
    Or we could use getters from QrCode in renderer like that:
    ```php
    $qrCode = new QrCode(/*...*/);
    $renderer = /*...*/
    $data = $renderer->render($qrCode);
    ```
    But I'd prefer double dispatch one because in this case `QrCode` and `Renderer` modules
    are less coupled to each other.
