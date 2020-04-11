<?php

namespace App\Helpers;

use Request;
use Str;
use Arr;

class QueryStringHelper
{

    public static function replaceParam(string $key, string $value)
    {

        $query = Request::query();

        $query[$key] = $value;

        return http_build_query($query, '', '&');

    }


    public static function routeWithParams(string $route, string $key, string $value)
    {
        return route($route) . '?' . self::replaceParam($key, $value);
    }


    public static function orderParams(string $value, string $direction = null)
    {

        $query = Request::query();

        $oldOrderby = isset($query['orderby']) ? $query['orderby'] : false;
        $oldOrder = isset($query['order']) ? $query['order'] : false;

        $order = 'asc';
        $orderby = $value;

        if ($direction) {
            $order = $direction;
        } else {

            if ($oldOrderby !== $value) {
                $order = 'asc';
            } else {

                if ($oldOrder === 'asc') {
                    $order = 'desc';
                } else {
                    $order = false;
                    $orderby = false;
                }

            }

        }

        if ($orderby) {
            $query['orderby'] = $orderby;
        } else {
            unset($query['orderby']);
        }

        if ($order) {
            $query['order'] = $order;
        } else {
            unset($query['order']);
        }

        return http_build_query($query, '', '&');

    }


    public static function routeWithOrderParams(string $route, string $value)
    {
        return route($route) . '?' . self::orderParams($value);
    }


    public static function paramToArray(string $param = null)
    {
        return explode('|', $param);
    }

    public static function arrToQueryStr(array $request)
    {
        return http_build_query($request);
    }

}