<?php

interface Validator
{
    public function validate($value): bool;
}