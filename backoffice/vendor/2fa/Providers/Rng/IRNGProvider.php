<?php
interface IRNGProvider
{
    public function getRandomBytes($bytecount);
    public function isCryptographicallySecure();
}