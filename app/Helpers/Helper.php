<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * trim multi byte function
 *
 * @return response()
 */
if (! function_exists('mbTrim')) {
    function mbTrim($str, $chars = '\s　')
    {
        $str = preg_replace("/^[$chars]+/u", '', $str);
        $str = preg_replace("/[$chars]+$/u", '', $str);

        return $str;
    }
}

if (! function_exists('removeWhiteSpaces')) {
    function removeWhiteSpaces($str, $replaceStr = '', $chars = '\s　')
    {
        return trim(preg_replace("/[$chars]+/u", $replaceStr, $str));
    }
}

/**
 * get min/max value by unit
 *
 * @return response()
 */
if (! function_exists('getMinMaxValueByUnit')) {
    function getMinMaxValueByUnit($unit, $isMin = false)
    {
        $value = null;
        switch ($unit) {
            case UNIT_QUANTITY:
                $value = $isMin ? UNIT_QUANTITY_MIN : UNIT_QUANTITY_MAX;
                break;
            case UNIT_AMOUNT:
                $value = $isMin ? UNIT_AMOUNT_MIN : UNIT_AMOUNT_MAX;
                break;
            case UNIT_RATIO:
                $value = $isMin ? UNIT_RATIO_MIN : UNIT_RATIO_MAX;
                break;
        }

        return $value;
    }
}

/**
 * validate min, max for input value by unit
 *
 * @return response()
 */
if (! function_exists('validMinMaxValue')) {
    function validMinMaxValue($value, $unit)
    {
        $flgCheck = false;
        switch ($unit) {
            case UNIT_QUANTITY:
                $flgCheck = ($value >= UNIT_QUANTITY_MIN && $value <= UNIT_QUANTITY_MAX) ? true : false;
                break;
            case UNIT_AMOUNT:
                $flgCheck = ($value >= UNIT_AMOUNT_MIN && $value <= UNIT_AMOUNT_MAX) ? true : false;
                break;
            case UNIT_RATIO:
                $flgCheck = ($value >= UNIT_RATIO_MIN && $value <= UNIT_RATIO_MAX) ? true : false;
                break;
        }

        return $flgCheck;
    }
}

if (! function_exists('countMonthBetweenTwoDates')) {
    function countMonthBetweenTwoDates($fromDate, $toDate)
    {
        $countMonth = 1;
        $toDateMonth = Carbon::parse($toDate)->format('Y-m');
        $nextMonth = Carbon::parse($fromDate)->format('Y-m');
        while ($nextMonth < $toDateMonth) {
            $countMonth++;
            $fromDate = $nextMonth;
            $nextMonth = Carbon::parse($fromDate)->addMonthsWithNoOverflow()->format('Y-m');
        }

        return $countMonth;
    }
}

if (! function_exists('roundToInteger')) {
    function roundToInteger($number)
    {
        return (int) round($number);
    }
}

if (! function_exists('mb_wordwrap')) {
    function mb_wordwrap($str, $width = 75, $break = "\n", $cut = false) {
        $lines = explode($break, $str);
        foreach ($lines as &$line) {
            $line = rtrim($line);
            if (mb_strlen($line) <= $width)
                continue;
            $words = explode(' ', $line);
            $line = '';
            $actual = '';
            foreach ($words as $word) {
                if (mb_strlen($actual.$word) <= $width)
                    $actual .= $word.' ';
                else {
                    if ($actual != '')
                        $line .= rtrim($actual).$break;
                    $actual = $word;
                    if ($cut) {
                        while (mb_strlen($actual) > $width) {
                            $line .= mb_substr($actual, 0, $width).$break;
                            $actual = mb_substr($actual, $width);
                        }
                    }
                    $actual .= ' ';
                }
            }
            $line .= trim($actual);
        }
        return implode($break, $lines);
    }
}

if (! function_exists('uploadFile')) {
    function uploadFile($filePath, $file, $fileName = null) {
        if (in_array(mb_strtolower(env('APP_ENV')), [STG_ENV, PRD_ENV])) {
            if ($fileName) {
                return Storage::disk('s3')->putFileAs($filePath, $file, $fileName);
            }

            return Storage::disk('s3')->put($filePath, $file);
        } else {
            if ($fileName) {
                return Storage::disk('public')->putFileAs($filePath, $file, $fileName);
            }

            return Storage::disk('public')->put($filePath, $file);
        }
    }
}

if (! function_exists('getFilePath')) {
    function getFilePath($filePath, $isGetFullPath = false, $ignoreExtenVersion = true) {
        if (!$filePath) return null;
        if (in_array(mb_strtolower(env('APP_ENV')), [STG_ENV, PRD_ENV])) {
            return Storage::disk('s3')
                ->url($filePath) . ($ignoreExtenVersion ? '' : '?' . Carbon::now()->format('Ymdhis'));
        } else {
            if (checkFileExists($filePath)) {
                $filePath = $isGetFullPath ?
                    public_path('storage/' . ltrim($filePath, '/')) : ('/storage/' . ltrim($filePath, '/'));
                return $filePath . ($ignoreExtenVersion ? '' : '?' . Carbon::now()->format('Ymdhis'));
            }

            return null;
        }
    }
}

if (! function_exists('deleteFile')) {
    function deleteFile($filePath) {
        if (in_array(mb_strtolower(env('APP_ENV')), [STG_ENV, PRD_ENV])) {
            if (Storage::disk('s3')->exists($filePath)) {
                Storage::disk('s3')->delete($filePath);
            }
        } else {
            if (checkFileExists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }
    }
}

if (! function_exists('checkFileExists')) {
    function checkFileExists($filePath) {
        return (in_array(mb_strtolower(env('APP_ENV')), [STG_ENV, PRD_ENV])) ?
        Storage::disk('s3')->exists($filePath) : file_exists(public_path('storage/' . ltrim($filePath, '/')));
    }
}

if (! function_exists('getNewFileName')) {
    function getNewFileName($directory, $fileName, $extension) {
        $extension = mb_strtolower($extension);
        $numIncrement = 0;

        while (checkFileExists("{$directory}" . $fileName . '.' . $extension)) {
            $regex = '/.*\([0-9]\d*\)\\.' . $extension . '$/';

            if (preg_match($regex, $fileName . '.' . $extension)) {
                $subFileName = mb_substr($fileName, 0, mb_strlen($fileName) - 1);
                $explodeSubFileName = explode('(', $subFileName);
                $numIncrement = array_pop($explodeSubFileName) + 1;
                $fileName = implode('(', $explodeSubFileName) . '(' . $numIncrement . ')';
            } else {
                $numIncrement += 1;
                $fileName = $fileName . '(' . $numIncrement . ')';
            }
        }

        return ($extension == '') ? $fileName : ($fileName . '.' . $extension);
    }
}

if (! function_exists('getRound')) {
    function getRound($value, $roundType = ROUND_UP) {
        return (ROUND_UP == $roundType) ? ceil($value) : floor($value);
    }
}

if (! function_exists('convertToHourMinute')) {
    function convertToHourMinute($minute, $hour = null) {
        if (is_null($hour)) {
            $hour = (int) ($minute / 60);
            $minute = $minute % 60;
        }

        return [
            'hour'          => $hour,
            'minute'        => $minute,
            'hour_minute_1' => number_format($hour) . ':' . sprintf('%02d', $minute),
            'hour_minute_2' => number_format($hour) . '時間' . sprintf('%02d', $minute) . '分',
        ];
    }
}
