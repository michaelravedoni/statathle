<?php

/* layouts/main.twig */
class __TwigTemplate_5263e8a2dccd9960696d345349d690da007aa73f3f14f15a8ffb2196c3beba8c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'bodyId' => array($this, 'block_bodyId'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!doctype html>
<html class=\"no-js\"";
        // line 2
        if ((twig_get_attribute($this->env, $this->getSourceContext(), ($context["config"] ?? null), "language_code", array(), "any", true, true) && twig_get_attribute($this->env, $this->getSourceContext(), (isset($context["config"]) || array_key_exists("config", $context) ? $context["config"] : (function () { throw new Twig_Error_Runtime('Variable "config" does not exist.', 2, $this->getSourceContext()); })()), "language_code", array()))) {
            echo " lang=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), (isset($context["config"]) || array_key_exists("config", $context) ? $context["config"] : (function () { throw new Twig_Error_Runtime('Variable "config" does not exist.', 2, $this->getSourceContext()); })()), "language_code", array()), "html_attr");
            echo "\"";
        }
        echo ">
    <head>
        <meta charset=\"utf-8\">

        ";
        // line 7
        echo "
        ";
        // line 8
        $context["title"] = "";
        // line 9
        echo "
        ";
        // line 10
        if (        $this->hasBlock("metaTitle", $context, $blocks)) {
            // line 11
            echo "            ";
            $context["title"] =             $this->renderBlock("metaTitle", $context, $blocks);
            // line 12
            echo "        ";
        }
        // line 13
        echo "
        ";
        // line 14
        if ((twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["config"] ?? null), "metas", array(), "any", false, true), "title", array(), "any", true, true) && twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), (isset($context["config"]) || array_key_exists("config", $context) ? $context["config"] : (function () { throw new Twig_Error_Runtime('Variable "config" does not exist.', 14, $this->getSourceContext()); })()), "metas", array()), "title", array()))) {
            // line 15
            echo "            ";
            if ((((isset($context["title"]) || array_key_exists("title", $context) ? $context["title"] : (function () { throw new Twig_Error_Runtime('Variable "title" does not exist.', 15, $this->getSourceContext()); })()) && twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["config"] ?? null), "metas", array(), "any", false, true), "title_separator", array(), "any", true, true)) && twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), (isset($context["config"]) || array_key_exists("config", $context) ? $context["config"] : (function () { throw new Twig_Error_Runtime('Variable "config" does not exist.', 15, $this->getSourceContext()); })()), "metas", array()), "title_separator", array()))) {
                // line 16
                echo "                ";
                $context["title"] = ((isset($context["title"]) || array_key_exists("title", $context) ? $context["title"] : (function () { throw new Twig_Error_Runtime('Variable "title" does not exist.', 16, $this->getSourceContext()); })()) . twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), (isset($context["config"]) || array_key_exists("config", $context) ? $context["config"] : (function () { throw new Twig_Error_Runtime('Variable "config" does not exist.', 16, $this->getSourceContext()); })()), "metas", array()), "title_separator", array()));
                // line 17
                echo "            ";
            }
            // line 18
            echo "
            ";
            // line 19
            $context["title"] = ((isset($context["title"]) || array_key_exists("title", $context) ? $context["title"] : (function () { throw new Twig_Error_Runtime('Variable "title" does not exist.', 19, $this->getSourceContext()); })()) . twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), (isset($context["config"]) || array_key_exists("config", $context) ? $context["config"] : (function () { throw new Twig_Error_Runtime('Variable "config" does not exist.', 19, $this->getSourceContext()); })()), "metas", array()), "title", array()));
            // line 20
            echo "        ";
        }
        // line 21
        echo "
        <title>";
        // line 22
        echo twig_escape_filter($this->env, (isset($context["title"]) || array_key_exists("title", $context) ? $context["title"] : (function () { throw new Twig_Error_Runtime('Variable "title" does not exist.', 22, $this->getSourceContext()); })()), "html", null, true);
        echo "</title>

        ";
        // line 25
        echo "
        ";
        // line 26
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->getSourceContext(), (isset($context["config"]) || array_key_exists("config", $context) ? $context["config"] : (function () { throw new Twig_Error_Runtime('Variable "config" does not exist.', 26, $this->getSourceContext()); })()), "metas", array()));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 27
            echo "            ";
            if (($context["value"] && !twig_in_filter($context["key"], array(0 => "title", 1 => "title_separator")))) {
                // line 28
                echo "        <meta name=\"";
                echo twig_escape_filter($this->env, $context["key"], "html_attr");
                echo "\" content=\"";
                echo twig_escape_filter($this->env, $context["value"], "html_attr");
                echo "\">
            ";
            }
            // line 30
            echo "        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 31
        echo "
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">

        <link rel=\"stylesheet\" href=\"assets/css/main.css\">
    </head>
    <body id=\"";
        // line 36
        $this->displayBlock('bodyId', $context, $blocks);
        echo "\">
        ";
        // line 37
        $this->displayBlock('content', $context, $blocks);
        // line 38
        echo "
        <script src=\"assets/js/main.js\"></script>

        ";
        // line 41
        if ((twig_get_attribute($this->env, $this->getSourceContext(), ($context["config"] ?? null), "google_analytics_id", array(), "any", true, true) && twig_get_attribute($this->env, $this->getSourceContext(), (isset($context["config"]) || array_key_exists("config", $context) ? $context["config"] : (function () { throw new Twig_Error_Runtime('Variable "config" does not exist.', 41, $this->getSourceContext()); })()), "google_analytics_id", array()))) {
            // line 42
            echo "        <script>
            window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
            ga('create','";
            // line 44
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), (isset($context["config"]) || array_key_exists("config", $context) ? $context["config"] : (function () { throw new Twig_Error_Runtime('Variable "config" does not exist.', 44, $this->getSourceContext()); })()), "google_analytics_id", array()), "html", null, true);
            echo "','auto');ga('send','pageview')
        </script>
        <script src=\"https://www.google-analytics.com/analytics.js\" async defer></script>
        ";
        }
        // line 48
        echo "    </body>
</html>";
    }

    // line 36
    public function block_bodyId($context, array $blocks = array())
    {
    }

    // line 37
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "layouts/main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  146 => 37,  141 => 36,  136 => 48,  129 => 44,  125 => 42,  123 => 41,  118 => 38,  116 => 37,  112 => 36,  105 => 31,  99 => 30,  91 => 28,  88 => 27,  84 => 26,  81 => 25,  76 => 22,  73 => 21,  70 => 20,  68 => 19,  65 => 18,  62 => 17,  59 => 16,  56 => 15,  54 => 14,  51 => 13,  48 => 12,  45 => 11,  43 => 10,  40 => 9,  38 => 8,  35 => 7,  24 => 2,  21 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!doctype html>
<html class=\"no-js\"{% if config.language_code is defined and config.language_code %} lang=\"{{ config.language_code|e('html_attr') }}\"{% endif %}>
    <head>
        <meta charset=\"utf-8\">

        {# page title #}

        {% set title = '' %}

        {% if block('metaTitle') is defined %}
            {% set title = block('metaTitle') %}
        {% endif %}

        {% if config.metas.title is defined and config.metas.title %}
            {% if title and config.metas.title_separator is defined and config.metas.title_separator %}
                {% set title = title ~ config.metas.title_separator %}
            {% endif %}

            {% set title = title ~ config.metas.title %}
        {% endif %}

        <title>{{ title }}</title>

        {# meta tags #}

        {% for key, value in config.metas %}
            {% if value and key not in ['title', 'title_separator'] %}
        <meta name=\"{{ key|e('html_attr') }}\" content=\"{{ value|e('html_attr') }}\">
            {% endif %}
        {% endfor %}

        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">

        <link rel=\"stylesheet\" href=\"assets/css/main.css\">
    </head>
    <body id=\"{% block bodyId %}{% endblock %}\">
        {% block content %}{% endblock %}

        <script src=\"assets/js/main.js\"></script>

        {% if config.google_analytics_id is defined and config.google_analytics_id %}
        <script>
            window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
            ga('create','{{ config.google_analytics_id }}','auto');ga('send','pageview')
        </script>
        <script src=\"https://www.google-analytics.com/analytics.js\" async defer></script>
        {% endif %}
    </body>
</html>", "layouts/main.twig", "/Users/michael/Sites/home/statathle2/app/templates/layouts/main.twig");
    }
}
