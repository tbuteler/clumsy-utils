<?php
namespace Clumsy\Utils\Library;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

class EnvironmentLocale
{

    protected $preferred = false;

    public function isKnown()
    {
        return (bool)$this->preferred;
    }

    public function preferred()
    {
        if (!$this->preferred && !Config::get('clumsy/utils::locales.passive')) {
            $original = setlocale(LC_MESSAGES, 0); // LC_MESSAGES is the most harmless of all categories
            $this->set(LC_MESSAGES);
            setlocale(LC_MESSAGES, $original);
        }

        return $this->preferred ? $this->preferred : App::getLocale();
    }

    public function set($category, $locales = false)
    {
        if (!$locales) {
            $locales = $this->getPossibleLocales(App::getLocale());
        }

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
        $sets = Config::get('clumsy/utils::locales');

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

    public function transform(\Closure $callback, $locale)
    {
        return call_user_func_array($callback, (array)$locale);
    }
}
