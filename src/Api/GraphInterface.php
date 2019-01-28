<?php

namespace Pixela\Api;

interface GraphInterface
{
    public function getId();

    public function getName();

    public function getUnit();

    public function getType();

    public function getColor();

    public function getTimezone();

    public function getPurgeCacheURLs();
}