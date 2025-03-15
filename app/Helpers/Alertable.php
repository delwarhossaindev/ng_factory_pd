<?php

namespace App\Helpers;

trait Alertable
{
    /**
     * Summary of success
     * @param string $route
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function success(string $route, string $message)
    {
        return redirect()->route($route)->with('message', $message);
    }

    /**
     * Summary of error
     * @param string $route
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function error(string $route, string $message)
    {
        return redirect()->route($route)->with('error', $message);
    }
}
