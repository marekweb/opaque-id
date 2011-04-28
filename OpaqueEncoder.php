<?php
/**
 * Opaque ID encoder.
 *
 * Translates between 32-bit integers (such as resource IDs) and obfuscated
 * scrambled values, as a one-to-one mapping. Supports hex and base64 url-safe
 * string representations. Expects a secret integer key in the constructor.
 *
 * (c) 2011 Marek Z. @marekweb
 */
class OpaqueEncoder {

	private $key;
	private $extraChars = '.-';
	
	/**
	 * @param $key Secret key used for lightweight encryption.
	 */
	public function __construct($key) {
		$this->key = $key;
	}
	
	/**
	 * Produce an integer hash of a 16-bit integer, returning a transformed 16-bit integer.
	 */
	protected function transform($i) {
		$i = ($this->key ^ $i) * 0x9e3b;
        return $i >> ($i & 0xf) & 0xffff;
	}
	
	/**
	 * Reversibly transcode a 32-bit integer to a scrambled form, returning a new 32-bit integer.
	 */
	public function transcode($i) {
		$r = $i & 0xffff;
		$l = $i >> 16 & 0xffff ^ $this->transform($r);
		return (($r ^ $this->transform($l)) << 16) + $l;
	}
	
	/**
	 * Transcode an integer and return it as an 8-character hex string.
	 */
	public function encodeHex($i) {
		return dechex($this->transcode($i));
	}
	
	/**
	 * Transcode an integer and return it as a 6-character base64 string.
	 */
	public function decodeHex($s) {
		return $this->transcode(hexdec($s));
	}
	
	/**
	 * Decode an 8-character hex string, returning the original integer.
	 */
	public function encodeBase64($i) {
		return strtr(substr(base64_encode(pack('N', $this->transcode($i))), 0, 6), '+/', $this->extraChars);
	}
	
	/**
	 * Decode a 6-character base64 string, returning the original integer.
	 */
	public function decodeBase64($s) {
		$unpacked = unpack('N', base64_decode(strtr($s, $this->extraChars, '+/')));
		return $this->transcode($unpacked[1]);
	}
}