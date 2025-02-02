<?php

namespace App\Enums;

class ModelsEnum
{
    const USERS      = 'users';
    const PAGES      = 'pages';
    const ROLES      = 'roles';
    const COUNTRY    = 'country';
    const SECTION    = 'section';
    const CATEGORY   = 'category';
    const SLIDER     = 'slider';
    const GALLERY    = 'gallery';
    const PARTNERS   = 'partners';
    const FAQ        = 'faq';
    const SETTINGS   = 'settings';
    const ORDERS     = 'orders';
    const INVOICES   = 'invoices';
    const CLIENTS    = 'clients';
    const LICENSES   = 'licenses';
    const PROGRAMS   = 'programs';

    public static function getAllModels()
    {
        return [
            self::USERS,
            self::PAGES,
            self::ROLES,
            self::COUNTRY,
            self::SECTION,
            self::CATEGORY,
            self::SLIDER,
            self::GALLERY,
            self::PARTNERS,
            self::FAQ,
            self::SETTINGS,
            self::ORDERS,
            self::INVOICES,
            self::CLIENTS,
            self::LICENSES,
            self::PROGRAMS,
        ];
    }
}
