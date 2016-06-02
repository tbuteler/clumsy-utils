<?php
namespace Clumsy\Utils\Library;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;

class EnvironmentLocale
{
    protected $app;

    protected $preferred = false;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function isKnown()
    {
        return (bool)$this->preferred;
    }

    public function preferred()
    {
        if (!$this->preferred && !config('clumsy.environment-locale.passive')) {
            $original = setlocale(LC_MESSAGES, 0); // LC_MESSAGES is the most harmless of all categories
            $this->set(LC_MESSAGES);
            setlocale(LC_MESSAGES, $original);
        }

        return $this->preferred ? $this->preferred : $this->app->getLocale();
    }

    public function set($category, $locale = false)
    {
        $locale = $locale ?: $this->app->getLocale();

        $locales = $this->getPossibleLocales($locale);

        foreach ((array)$locales as $locale) {
            if (setlocale($category, $locale) !== false) {
                $this->preferred = $locale;
                break;
            }
        }
    }

    public function getPossibleLocales($locale)
    {
        $bases = (array)$locale;
        $sets = config('clumsy.environment-locale');

        foreach ((array)$sets['equivalences'] as $locale_code => $equivalence) {
            if ($locale_code === head($bases)) {
                $bases[] = $equivalence;
            }
        }

        foreach ($sets['transformations'] as $transformation) {
            $bases[] = $this->transform($transformation, head($bases));
        }

        foreach ((array)$sets['append'] as $append) {
            foreach ($bases as $base) {
                $locales[] = $base.$append;
            }
        }

        foreach ($bases as $base) {
            $locales[] = $base;
        }

        return array_unique(array_filter($locales));
    }

    public function transform($callback, $locale)
    {
        if (!($callback instanceof Closure) && str_contains($callback, '@')) {
            $callback = explode('@', $callback, 2);
        }

        return call_user_func_array($callback, (array)$locale);
    }

    public static function replaceUnderscoreTransformation($locale)
    {
        return str_replace('_', '-', $locale);
    }

    public static function replaceDashTransformation($locale)
    {
        return str_replace('-', '_', $locale);
    }

    public function duplicateLocaleTransformation($locale)
    {
        if (!str_contains($locale, ['_', '-'])) {
            return Str::lower($locale).'_'.Str::upper($locale);
        }

        return $locale;
    }
}
