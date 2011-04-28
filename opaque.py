import struct
import base64

__version__ = '0.0.1'

class OpaqueEncoder:
    """
    Opaque ID encoder.

    Translates between 32-bit integers (such as resource IDs) and obfuscated
    scrambled values, as a one-to-one mapping. Supports hex and base64 url-safe
    string representations. Expects a secret integer key in the constructor.

    (c) 2011 Marek Z. @marekweb
    """
    
    def __init__(self, key):
        self.key = key
        self.extra_chars = '.-';
        
    def transform(self, i):
        """Produce an integer hash of a 16-bit integer, returning a transformed 16-bit integer."""
        i = (self.key ^ i) * 0x9e3b
        return i >> (i & 0xf) & 0xffff

    def transcode(self, i):
        """Reversibly transcode a 32-bit integer to a scrambled form, returning a new 32-bit integer."""
        r = i & 0xffff         
        l = i >> 16 & 0xffff ^ self.transform(r)
        return ((r ^ self.transform(l)) << 16) + l

    def encode_hex(self, i):
        """Transcode an integer and return it as an 8-character hex string."""
        return "%08x" % self.transcode(i)

    def encode_base64(self, i):
        """Transcode an integer and return it as a 6-character base64 string."""
        return base64.b64encode(struct.pack('!L', self.transcode(i)), self.extra_chars)[:6]
    
    def decode_hex(self, s):
        """Decode an 8-character hex string, returning the original integer."""
        return self.transcode(int(s, 16))

    def decode_base64(self, s):
        """Decode a 6-character base64 string, returning the original integer."""
        return self.transcode(struct.unpack('!L', base64.b64decode(s + '==', self.extra_chars))[0])



