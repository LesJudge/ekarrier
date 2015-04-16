<?php

interface DeletableByResourceInterface extends \ResourcableInterface
{
    public static function deleteByResource(\ResourceInterface $ri);
}