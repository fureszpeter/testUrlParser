# Competency test

## Description

Create a simple class which parses a URL.
 
The constructor should accept a full or a partial URL, then I could get the different parts of it, 
e.g. protocol, host, path, etc. through getters.

No setters needed, this would be an immutable object class.

There should be a `__toString()` method implemented, so I could cast my `$url` object to a string easily, e.g.: 

```php
echo (string)$url;
```

There should be unit tests for all public methods.

## Bonus

An added bonus could be if the class would normalize the path of the URL on instantiation, 
so if the input URL has a path with '.' or '..' in it, those would be removed.
