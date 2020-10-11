<?php
interface IQRCodeProvider
{
    public function getQRCodeImage($qrtext, $size);
    public function getMimeType();
}