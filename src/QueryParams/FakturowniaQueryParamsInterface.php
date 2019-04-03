<?php

namespace Gmigroup\Clients\Fakturownia\QueryParams;

interface FakturowniaQueryParamsInterface
{
    public const PERIOD_LAST_12_MONTHS = 'last_12_months';
    public const PERIOD_THIS_MONTH = 'this_month';
    public const PERIOD_LAST_30_DAYS = 'last_30_days';
    public const PERIOD_LAST_MONTH = 'last_month';
    public const PERIOD_THIS_YEAR = 'this_year';
    public const PERIOD_LAST_YEAR = 'last_year';
    public const PERIOD_ALL = 'all';
    public const PERIOD_MORE = 'more';
    public const PERIOD_MORE_PARAMS = ['date_from', 'date_to'];

    public const ALL_PERIODS = [
        self::PERIOD_LAST_12_MONTHS,
        self::PERIOD_THIS_MONTH,
        self::PERIOD_LAST_30_DAYS,
        self::PERIOD_LAST_MONTH,
        self::PERIOD_THIS_YEAR,
        self::PERIOD_LAST_YEAR,
        self::PERIOD_ALL,
        self::PERIOD_MORE
    ];

    public const PAGE_PARAM = 'page';

    public const PRINT_OPTION_ORIGINAL = 'original';
    public const PRINT_OPTION_COPY = 'copy';
    public const PRINT_OPTION_ORIGINAL_AND_COPY = 'original_and_copy';
    public const PRINT_OPTION_DUPLICATE = 'duplicate';
}
