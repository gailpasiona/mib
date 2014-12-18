<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Validator::extend('alpha_spaces', function($attribute, $value)
{
    return preg_match('/^[\pL\s0-9]+$/u', $value);
});

Validator::extend('alpha_spaces_letteronly', function($attribute, $value)
{
    return preg_match('/^[\pL\s]+$/u', $value);
});

validator::extend('amount', function($attribute, $value)
{
    return preg_match('/^([1-9][0-9]*|0)(\.[0-9]{2})?$/', $value);
});