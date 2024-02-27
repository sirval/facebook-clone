<?php

namespace App;

class Constants
{
    //User Roles
    const SYSTEM_ROLES = ['admin', 'user'];


    const PERMISSIONS = [
        'create post',
        'update own post',
        'update all post',
        'view post ',
        'view own post',
        'delete own post',
        'delete all post',

        'create comment',
        'update all comment',
        'update own comment',
        'view comment ',
        'view own comment',
        'delete own comment',
        'delete all comment',
    ];

    const ADMIN_PERMISSIONS = [
        'create post',
        'update own post',
        'update all post',
        'view post ',
        'view own post',
        'delete own post',
        'delete all post',

        'create comment',
        'update all comment',
        'update own comment',
        'view comment ',
        'view own comment',
        'delete own comment',
        'delete all comment',
    ];

    const USER_PERMISSIONS = [
        'create post',
        'view post ',
        'view own post',
        'update own post',
        'delete own post',

        'update own comment',
        'create comment',
        'view comment ',
        'view own comment',
        'delete own comment',
    ];
}