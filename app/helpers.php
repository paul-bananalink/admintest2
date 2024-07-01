<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;

if (!function_exists('formatNumber')) {
    function formatNumber(?string $value = '')
    {
        if (empty($value)) {
            return 0;
        }

        return number_format(floatval($value), 0, '.', ',');
    }
}

if (!function_exists('minutesToDateTime')) {
    function minutesToDateTime(?int $minutes = 120): DateTime
    {
        if (empty($minutes)) {
            return now()->toDateTime();
        }

        return now()->addSeconds(now()->diffInSeconds(now()->addMinutes($minutes)))->toDateTime();
    }
}

if (!function_exists('parseStringToDateRange')) {

    function parseStringToDateRange(string $datetime, string $format = 'Y-m-d'): array
    {
        $dateArray = explode(" - ", $datetime);

        $start = date("Y-m-d 00:00:00", strtotime($dateArray[0]));
        $end = date("Y-m-d 23:59:59", strtotime($dateArray[1]));

        return [$start, $end];
    }
}

if (!function_exists('formatDate')) {
    function formatDate(string $datetime, string $format = 'Y.m.d'): string
    {
        $date = date($format, strtotime($datetime));
        return $date;
    }
}

if (!function_exists('formatImageUrlApi')) {
    function formatImageUrlApi(string $upload_url): string
    {
        if (empty($upload_url)) return '';
        $url = env('API_URL', '');
        $url = rtrim($url, '/');
        return $url . '/' . $upload_url;
    }
}

if (!function_exists('getImageUrl')) {
    function getImageUrl(string $imageUrl): string
    {
        return str_starts_with($imageUrl, 'uploads/') ? formatImageUrlApi($imageUrl) : $imageUrl;
    }
}

if (!function_exists('convertKeyToCamelCase')) {
    function convertKeyToCamelCase(array $array): array
    {
        $arrayNew = array();
        foreach ($array as $key => $value) {
            // Convert underscore-separated words to camelCase
            $newKey = lcfirst(str_replace('_', '', ucwords($key, '_')));
            $arrayNew[$newKey] = $value;
        }
        return $arrayNew;
    }
}

if (!function_exists('convertApiDomainToAppDomain')) {
    function convertApiDomainToAppDomain(string $url): string
    {
        return env('APP_URL') . parse_url($url, PHP_URL_PATH);
    }
}


if (!function_exists('parseMinutes')) {
    function parseMinutes(?string $time): array
    {
        if (!$time) return [];

        $arrOffTime = explode(' - ', $time);
        $startTime = explode(':', $arrOffTime[0])[1];
        $endTime = explode(':', $arrOffTime[1])[1];

        return ['start_time' => $startTime, 'end_time' => $endTime];
    }
}

if (!function_exists('convertDateTimeRangeToString')) {
    function convertDateTimeRangeToString(string $fromDate, string $fromTime, string $toDate, string $toTime): string
    {
        $from = Carbon::parse($fromDate . ' ' . $fromTime);
        $to = Carbon::parse($toDate . ' ' . $toTime);

        $formattedFrom = $from->format('Y-m-d H:i');
        $formattedTo = $to->format('Y-m-d H:i');

        return $formattedFrom . ' - ' . $formattedTo;
    }
}

if (!function_exists('convertStringToDateTimeRange')) {
    function convertStringToDateTimeRange(?string $dateTimeRange): array
    {
        if (!$dateTimeRange) return [];

        $times = explode(' - ', $dateTimeRange);
        $fromTime = explode(' ', $times[0]);
        $toTime = explode(' ', $times[1]);

        return [
            'from_date' => $fromTime[0],
            'from_time' => $fromTime[1],
            'to_date' => $toTime[0],
            'to_time' => $toTime[1],
        ];
    }
}

if (!function_exists('formatImageUrlAdmin')) {
    function formatImageUrlAdmin(string $upload_url): string
    {
        if (empty($upload_url)) return '';
        $url = env('APP_URL', '');
        $url = rtrim($url, '/');
        return $url . '/' . $upload_url;
    }
}

if (!function_exists('discordSendMessage')) {
    function discordSendMessage(string $message = "", string $bot_token = ''): bool
    {
        if ($message == "") return false;

        $url = env('DISCORD_WEBHOOK_URL', '');

        $headers = [
            'Authorization: Bot ' . env('DISCORD_BOT_TOKEN', ''),
            'Content-Type: application/json',
        ];

        $data = [
            'content' => $message
        ];

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        return (bool)$result;
    }
}

if (!function_exists('isApiDomain')) {
    function isApiDomain(): bool
    {
        $domain = request()->getSchemeAndHttpHost();

        return $domain == env('API_URL');
    }
}

if (!function_exists('isAdminDomain')) {
    function isAdminDomain(): bool
    {
        $domain = request()->getSchemeAndHttpHost();

        return $domain == env('APP_URL');
    }
}

if (!function_exists('stringToArray')) {
    function stringToArray(?string $string): array
    {
        if (empty($string)) return [];

        $array = preg_split('/\r\n|\r|\n/', $string);

        return array_map('trim', $array);
    }
}

if (!function_exists('hashString')) {
    function hashString(?string $string, int $letter = 4): ?string
    {
        if (empty($string)) return null;
        $length = strlen($string);
        $hash_count = $length < $letter ? $length : $letter;

        return substr_replace($string, str_repeat('*', $hash_count), $length - $hash_count);
    }
}

if (!function_exists('convertFloat')) {
    function convertFloat(array|string|null $data): array|float|null
    {
        if (is_null($data)) return null;

        if (gettype($data) === 'string') {
            $value = str_replace(',', '', $data);
            return floatval($value);
        }

        return array_map(function ($subArray) {
            return array_map(function ($value) {
                $value = str_replace(',', '', $value);
                return floatval($value);
            }, $subArray);
        }, $data);
    }
}

if (!function_exists('checkCurrentDateTimeInRange')) {
    function checkCurrentDateTimeInRange(array|string $dateTimeData): bool
    {
        if (gettype($dateTimeData) === 'string') {
            [$from, $to] = explode(' - ', $dateTimeData);
            $from = Carbon::parse($from);
            $to = Carbon::parse($to);

            $dateTimeRange = CarbonPeriod::create($from, $to);
        } else {
            $from = Carbon::parse($dateTimeData['from_date'] . ' ' . $dateTimeData['from_time']);
            $to = Carbon::parse($dateTimeData['to_date'] . ' ' . $dateTimeData['to_time']);

            $dateTimeRange = CarbonPeriod::create($from, $to);
        }

        return $dateTimeRange->contains(now());
    }
}
