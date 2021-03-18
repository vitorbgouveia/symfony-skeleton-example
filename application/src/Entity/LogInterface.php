<?php

namespace App\Entity;

interface LogInterface
{
    public function getUpdateLogMessage(array $changeSets, $entity): array;
}