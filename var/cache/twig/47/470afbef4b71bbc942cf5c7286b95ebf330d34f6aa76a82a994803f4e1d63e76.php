<?php

/* front/home.twig */
class __TwigTemplate_f7d8fbf25c1f0a2f87117ceae36490b610dd2537ceb31b0f972fa033d8289f96 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layouts/main.twig", "front/home.twig", 1);
        $this->blocks = array(
            'bodyId' => array($this, 'block_bodyId'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layouts/main.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_bodyId($context, array $blocks = array())
    {
        echo "home";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "<p>Hello world! This is Slim 3 Skeleton.</p>
";
    }

    public function getTemplateName()
    {
        return "front/home.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 6,  35 => 5,  29 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"layouts/main.twig\" %}

{% block bodyId %}home{% endblock %}

{% block content %}
<p>Hello world! This is Slim 3 Skeleton.</p>
{% endblock %}", "front/home.twig", "/Users/michael/Sites/home/statathle2/app/templates/front/home.twig");
    }
}
