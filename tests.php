<?php
/**
 * Basic test for OpaqueEncoder.
 *
 * Checks round-trip encoding with random values. Uses assert statements, so
 * if no errors show up, the test was successful.
 */

require_once 'OpaqueEncoder.php';

print "Starting tests... ";

$key = mt_rand();

$encoder = new OpaqueEncoder($key, OpaqueEncoder::ENCODING_INT);


for ($i = 0; $i < 800; $i++) {
	$n = mt_rand();
	$encoded = $encoder->encode($n);
	assert($n == $encoder->decode($encoded));
}

$encoder = new OpaqueEncoder($key, OpaqueEncoder::ENCODING_HEX);

for ($i = 0; $i < 800; $i++) {
	$n = mt_rand();
	$encoded = $encoder->encode($n);
	assert($n == $encoder->decode($encoded));
}

$encoder = new OpaqueEncoder($key, OpaqueEncoder::ENCODING_BASE64);

for ($i = 0; $i < 800; $i++) {
	$n = mt_rand();
	$encoded = $encoder->encode($n);
	assert($n == $encoder->decode($encoded));
}

print "Done.";
