<?php

interface AttachedUserFinderInterface
{
    public function findAndSet($attachedId, &$params);
}