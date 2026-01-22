<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* index.html.twig */
class __TwigTemplate_8d19d36449a08b7d5bb90515e8bcf0a1 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "layout/base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $this->parent = $this->load("layout/base.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 3
        yield "<main class=\"flex-1 overflow-auto\">
    <div class=\"p-8\">
        <!-- Dashboard Section -->
        <div class=\"mb-8\">
            <h2 class=\"text-3xl font-bold text-gray-800 mb-2\">Dashboard</h2>
            <p class=\"text-gray-600\">Bem-vindo ao sistema de agendamento</p>
        </div>

        <ul>
            ";
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["manicures"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["manicure"]) {
            // line 13
            yield "                <li>";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v0 = $context["manicure"]) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0["nome"] ?? null) : null), "html", null, true);
            yield " (";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v1 = $context["manicure"]) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1["email"] ?? null) : null), "html", null, true);
            yield ")</li>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['manicure'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 15
        yield "        </ul>
        
        <div class=\"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8\">
            <div class=\"card p-6\">
                <div class=\"flex items-center justify-between\">
                    <div>
                        <p class=\"text-gray-600 text-sm font-medium\">Total de Manicures</p>
                        <p class=\"text-3xl font-bold text-purple-600 mt-2\" id=\"total-manicures\">0</p>
                    </div>
                    <span class=\"material-icons text-4xl text-purple-200\">people</span>
                </div>
            </div>
            
            <div class=\"card p-6\">
                <div class=\"flex items-center justify-between\">
                    <div>
                        <p class=\"text-gray-600 text-sm font-medium\">Total de Clientes</p>
                        <p class=\"text-3xl font-bold text-purple-600 mt-2\" id=\"total-clientes\">0</p>
                    </div>
                    <span class=\"material-icons text-4xl text-purple-200\">person</span>
                </div>
            </div>
            
            <div class=\"card p-6\">
                <div class=\"flex items-center justify-between\">
                    <div>
                        <p class=\"text-gray-600 text-sm font-medium\">Agendamentos Hoje</p>
                        <p class=\"text-3xl font-bold text-purple-600 mt-2\" id=\"agendamentos-hoje\">0</p>
                    </div>
                    <span class=\"material-icons text-4xl text-purple-200\">event</span>
                </div>
            </div>
            
            <div class=\"card p-6\">
                <div class=\"flex items-center justify-between\">
                    <div>
                        <p class=\"text-gray-600 text-sm font-medium\">Itens em Estoque</p>
                        <p class=\"text-3xl font-bold text-purple-600 mt-2\" id=\"itens-estoque\">0</p>
                    </div>
                    <span class=\"material-icons text-4xl text-purple-200\">inventory_2</span>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class=\"grid grid-cols-1 lg:grid-cols-2 gap-6\">
            <div class=\"card p-6\">
                <h3 class=\"text-lg font-semibold text-gray-800 mb-4\">Próximos Agendamentos</h3>
                <div id=\"proximos-agendamentos\" class=\"space-y-3\">
                    <div class=\"text-center text-gray-500 py-8\">
                        <span class=\"material-icons text-4xl mb-2 block text-gray-300\">event</span>
                        Nenhum agendamento próximo
                    </div>
                </div>
            </div>

            <div class=\"card p-6\">
                <h3 class=\"text-lg font-semibold text-gray-800 mb-4\">Estoque Baixo</h3>
                <div id=\"estoque-baixo\" class=\"space-y-3\">
                    <div class=\"text-center text-gray-500 py-8\">
                        <span class=\"material-icons text-4xl mb-2 block text-gray-300\">inventory_2</span>
                        Todos os itens com estoque adequado
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "index.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  84 => 15,  73 => 13,  69 => 12,  58 => 3,  51 => 2,  40 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"layout/base.html.twig\" %}
{% block content %}
<main class=\"flex-1 overflow-auto\">
    <div class=\"p-8\">
        <!-- Dashboard Section -->
        <div class=\"mb-8\">
            <h2 class=\"text-3xl font-bold text-gray-800 mb-2\">Dashboard</h2>
            <p class=\"text-gray-600\">Bem-vindo ao sistema de agendamento</p>
        </div>

        <ul>
            {% for manicure in manicures %}
                <li>{{ manicure['nome'] }} ({{ manicure['email'] }})</li>
            {% endfor %}
        </ul>
        
        <div class=\"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8\">
            <div class=\"card p-6\">
                <div class=\"flex items-center justify-between\">
                    <div>
                        <p class=\"text-gray-600 text-sm font-medium\">Total de Manicures</p>
                        <p class=\"text-3xl font-bold text-purple-600 mt-2\" id=\"total-manicures\">0</p>
                    </div>
                    <span class=\"material-icons text-4xl text-purple-200\">people</span>
                </div>
            </div>
            
            <div class=\"card p-6\">
                <div class=\"flex items-center justify-between\">
                    <div>
                        <p class=\"text-gray-600 text-sm font-medium\">Total de Clientes</p>
                        <p class=\"text-3xl font-bold text-purple-600 mt-2\" id=\"total-clientes\">0</p>
                    </div>
                    <span class=\"material-icons text-4xl text-purple-200\">person</span>
                </div>
            </div>
            
            <div class=\"card p-6\">
                <div class=\"flex items-center justify-between\">
                    <div>
                        <p class=\"text-gray-600 text-sm font-medium\">Agendamentos Hoje</p>
                        <p class=\"text-3xl font-bold text-purple-600 mt-2\" id=\"agendamentos-hoje\">0</p>
                    </div>
                    <span class=\"material-icons text-4xl text-purple-200\">event</span>
                </div>
            </div>
            
            <div class=\"card p-6\">
                <div class=\"flex items-center justify-between\">
                    <div>
                        <p class=\"text-gray-600 text-sm font-medium\">Itens em Estoque</p>
                        <p class=\"text-3xl font-bold text-purple-600 mt-2\" id=\"itens-estoque\">0</p>
                    </div>
                    <span class=\"material-icons text-4xl text-purple-200\">inventory_2</span>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class=\"grid grid-cols-1 lg:grid-cols-2 gap-6\">
            <div class=\"card p-6\">
                <h3 class=\"text-lg font-semibold text-gray-800 mb-4\">Próximos Agendamentos</h3>
                <div id=\"proximos-agendamentos\" class=\"space-y-3\">
                    <div class=\"text-center text-gray-500 py-8\">
                        <span class=\"material-icons text-4xl mb-2 block text-gray-300\">event</span>
                        Nenhum agendamento próximo
                    </div>
                </div>
            </div>

            <div class=\"card p-6\">
                <h3 class=\"text-lg font-semibold text-gray-800 mb-4\">Estoque Baixo</h3>
                <div id=\"estoque-baixo\" class=\"space-y-3\">
                    <div class=\"text-center text-gray-500 py-8\">
                        <span class=\"material-icons text-4xl mb-2 block text-gray-300\">inventory_2</span>
                        Todos os itens com estoque adequado
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
{% endblock %}", "index.html.twig", "/var/www/html/src/Views/index.html.twig");
    }
}
