<?php

if (!function_exists('user')) {
    function user()
    {
        return auth()->user();
    }
}

if (!function_exists('id')) {
    function id()
    {
        return auth()->id();
    }
}

if (!function_exists('unknown_error')) {
    function unknown_error(): string
    {
        return 'Сервер временно недоступен';
    }
}

if (!function_exists('response_json')) {
    function response_json(array $data = [], string $message = '', bool $success = true)
    {
        if (empty($message)) {
            return response()->json(['success' => $success] + $data);
        }

        return response()->json(['success' => $success, 'message' => $message] + $data);
    }
}

if (!function_exists('response_unknown_error')) {
    function response_unknown_error()
    {
        return response()->json(['success' => false, 'message' => unknown_error()]);
    }
}

if (!function_exists('response_success')) {
    function response_success(?string $message = '')
    {
        if (empty($message)) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => true, 'message' => $message]);
    }
}

if (!function_exists('response_error')) {
    function response_error(?string $message = '')
    {
        return response()->json(['success' => false, 'message' => $message]);
    }
}

if (!function_exists('cff')) {
    function cff(string $format, $datetime): ?Carbon\Carbon
    {
        if (empty($datetime)) {
            return null;
        }

        if (is_string($datetime)) {
            return Carbon\Carbon::createFromFormat($format, $datetime);
        }

        return $datetime;
    }
}

if (!function_exists('date_to_db')) {
    function date_to_db($datetime, string $format = 'd.m.Y H:i'): ?string
    {
        try {
            if (empty($datetime)) {
                return null;
            }

            if (is_string($datetime)) {
                return cff($format, $datetime)->format('Y-m-d H:i:s');
            }

            return $datetime->format('Y-m-d H:i:s');
        } catch (Throwable) {
            return null;
        }
    }
}

if (!function_exists('db_to_date')) {
    function db_to_date($datetime, string $format = 'd.m.Y'): ?string
    {
        try {
            if (empty($datetime)) {
                return null;
            }

            if (is_string($datetime)) {
                return cff('Y-m-d H:i:s', $datetime)->format($format);
            }

            return $datetime->format($format);
        } catch (Throwable) {
            return null;
        }
    }
}

if (!function_exists('sanitize_file_name')) {
    function sanitize_file_name(?string $fileName): ?string
    {
        if (empty($fileName)) {
            return null;
        }

        return \Illuminate\Support\Str::lower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
    }
}

if (!function_exists('gen_file_name')) {
    function gen_file_name($fileOrExtension): ?string
    {
        if (is_string($fileOrExtension)) {
            return Illuminate\Support\Str::lower(\Illuminate\Support\Str::random()).'.'.
                request()->file($fileOrExtension)->getClientOriginalExtension();
        }

        return Illuminate\Support\Str::lower(\Illuminate\Support\Str::random()).'.'.
            $fileOrExtension->getClientOriginalExtension();
    }
}
