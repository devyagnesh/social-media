<?php
function TokenGenerate()
{
    $RandomValue = random_bytes(16);
    $MaskValue = md5(bin2hex($RandomValue));

    return $MaskValue;
}
