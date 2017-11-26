<?php

namespace Korona\Interfaces;

interface PersonInterface
{
    public function identifiableName();
    public function getBackendEditUrl();
    public function addresses();
    public function address();
    public function phonenumbers();
}
