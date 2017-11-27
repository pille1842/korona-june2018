<?php

namespace Korona\Interfaces;

interface PersonInterface
{
    public function identifiableName();
    public function getBackendEditUrl();
    public function addresses();
    public function address();
    public function emails();
    public function email();
    public function phonenumbers();
    public function subscriptions();
}
