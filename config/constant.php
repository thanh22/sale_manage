<?php

/*
  |--------------------------------------------------------------------------
  | Application constants
  |--------------------------------------------------------------------------
  |
 */
// check if DEFINE_CONSTANT is defined.
// usually this file is not loaded twice or more,
// but this file is loaded during every unit test is called.

if (!defined('DEFINE_CONSTANT')) {
    define('DEFINE_CONSTANT', 1);

    define('ACCEPT_ENGINEER_FILE', 'jpeg,png,jpg,doc,docs,docx,pdf,xls,xlsx,ppt,pptx,csv,txt');
    define('ACCEPT_FILE', 'doc,docs,docx,pdf,xls,xlsx,csv,txt');
    define('ACCEPT_CONTRACT_FILE', 'doc,docs,docx,pdf,xls,xlsx,ppt,pptx,csv,txt');
    define('ACCEPT_IMPORT_EXCEL_FILE', 'xls,xlsx');
    define('ACCEPT_IMPORT_CSV_FILE', 'csv,txt');
    define('ACCEPT_NOTICE_FILE', 'doc,docs,docx,pdf,xls,xlsx,ppt,pptx,png,jpeg,jpg');

    // define environments
    define('LOCAL_ENV', 'local');
    define('STG_ENV', 'stg');
    define('PRD_ENV', 'production');

    // Common
    define('ENABLE', 1);
    define('DISABLE', 0);
    define('BC_MATH_SCALE', 3); // https://www.php.net/manual/en/ref.bc.php

    define('CODE_SUCCESS', 200);
    define('CODE_UNAUTHORIZED', 401);
    define('CODE_FORBIDDEN', 403);
    define('CODE_NOT_FOUND', 404);
    define('CODE_UNPROCESSABLE_ENTITY', 422);
    define('CODE_INTERNAL_SERVER_ERROR', 500);
    define('CODE_COMPANY_SERVICE_PLAN_EXPIRED', 555);

    define('PAGE_LIMIT', 50);
    define('MIDSIZE_PAGE_LIMIT', 30);
    define('MEDIUM_PAGE_LIMIT', 20);
    define('SMALL_PAGE_LIMIT', 10);

    define('SORT_TYPE_ASC', 'ASC');
    define('SORT_TYPE_DESC', 'DESC');
}
