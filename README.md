Opaque ID: Obfuscation for integer IDs
======================================

Opaque ID obfuscates integers using a reversible scheme based on a secret key.

It aims to hide resource/database IDs from observers when included in public URLs or API responses, without the need for surrogate database keys.

Here's what Opaque IDs look like:

```
      ID    Opaque Hex  Opaque Base64
       0     7ea0aa7a      fqCqeg
       1     0ae54fa3      CuVPow
       2     cbae9d6c      y66dbA
       3     db2ac148      2yrBSA
```

The algorithm is a one-to-one integer mapping (which incorporates a secret key). It's lightweight and compact, at the cost of actual cryptographic security. For real encryption, use a serious encryption algorithm instead (although you won't get such a compact ciphertext). 

Usage
-----

Here's how you use Opaque ID (Python example):

```python
# Create an instance with your secret key (pick your own key!)
encoder = opaque.OpaqueEncoder(0x3b79db9a) 

print encoder.encode_hex(3)
# -> db2ac148

print encoder.encode_base64(3)
# -> 2yrBSA

print encoder.decode_base64("2yrBSA")
# -> 3
```

Here's a PHP example

```php
$encoder = new OpaqueEncoder(0x3b79db9a);
print $encoder->encode($id); // Default mode is hex

$encoder = new OpaqueEncoder(0x3b79db9a, OpaqueEncoder::ENCODING_BASE64);
print $encoder->encode($id); // Will use base64 mode
```

Install the class using composer:

```bash
composer require marekweb/opaque-id
```

Then require it with:

```php
require 'vendor/autoload.php';
$encoder = new OpaqueEncoder(0x3b79db9a);
```

Implementations
---------------

* PHP: `OpaqueEncoder.php` class
* Python: `opaque.py` module

Authors
-------

(c) 2011 Marek Z. @marekweb
