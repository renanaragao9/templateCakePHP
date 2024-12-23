<?php
declare (strict_types = 1);

namespace Cake\View\Helper;

use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\View\Helper;
use Cake\View\StringTemplate;
use Cake\View\StringTemplateTrait;
use Cake\View\View;
use function Cake\Core\h;
use function Cake\I18n\__;

class PaginatorHelper extends Helper
{
    use StringTemplateTrait;

    protected $helpers = ['Url', 'Number', 'Html', 'Form'];

    protected $_defaultConfig = [
        'options' => [],
        'templates' => [
            'nextActive' => '<li class="page-item"><a class="page-link text-dark" rel="next" href="{{url}}">{{text}}</a></li>',
            'nextDisabled' => '<li class="page-item disabled"><a class="page-link text-dark" href="" onclick="return false;">{{text}}</a></li>',
            'prevActive' => '<li class="page-item"><a class="page-link text-dark" rel="prev" href="{{url}}">{{text}}</a></li>',
            'prevDisabled' => '<li class="page-item disabled"><a class="page-link text-dark" href="" onclick="return false;">{{text}}</a></li>',
            'counterRange' => '<span class="text-dark">{{start}} - {{end}} de {{count}}</span>',
            'counterPages' => '<span class="text-dark">{{page}} de {{pages}}</span>',
            'first' => '<li class="page-item"><a class="page-link text-dark" href="{{url}}">{{text}}</a></li>',
            'last' => '<li class="page-item"><a class="page-link text-dark" href="{{url}}">{{text}}</a></li>',
            'number' => '<li class="page-item"><a class="page-link text-dark" href="{{url}}">{{text}}</a></li>',
            'current' => '<li class="page-item active"><a class="page-link text-dark" href="">{{text}}</a></li>',
            'ellipsis' => '<li class="page-item disabled"><a class="page-link text-dark" href="">&hellip;</a></li>',
            'sort' => '<a class="text-dark" href="{{url}}">{{text}}</a>',
            'sortAsc' => '<a class="asc text-dark" href="{{url}}">{{text}}</a>',
            'sortDesc' => '<a class="desc text-dark" href="{{url}}">{{text}}</a>',
            'sortAscLocked' => '<a class="asc locked text-dark" href="{{url}}">{{text}}</a>',
            'sortDescLocked' => '<a class="desc locked text-dark" href="{{url}}">{{text}}</a>',
        ],
    ];

    protected $_defaultModel;

    public function __construct(View $view, array $config = [])
    {
        parent::__construct($view, $config);

        $query = $this->_View->getRequest()->getQueryParams();
        unset($query['page'], $query['limit'], $query['sort'], $query['direction']);
        $this->setConfig(
            'options.url',
            array_merge($this->_View->getRequest()->getParam('pass', []), ['?' => $query])
        );
    }

    public function params(?string $model = null): array
    {
        $request = $this->_View->getRequest();

        if (empty($model)) {
            $model = (string) $this->defaultModel();
        }

        $params = $request->getAttribute('paging');

        return empty($params[$model]) ? [] : $params[$model];
    }

    public function param(string $key, ?string $model = null)
    {
        $params = $this->params($model);

        return $params[$key] ?? null;
    }

    public function options(array $options = []): void
    {
        $request = $this->_View->getRequest();

        if (!empty($options['paging'])) {
            $request = $request->withAttribute(
                'paging',
                $options['paging'] + $request->getAttribute('paging', [])
            );
            unset($options['paging']);
        }

        $model = (string) $this->defaultModel();
        if (!empty($options[$model])) {
            $params = $request->getAttribute('paging', []);
            $params[$model] = $options[$model] + Hash::get($params, $model, []);
            $request = $request->withAttribute('paging', $params);
            unset($options[$model]);
        }

        $this->_View->setRequest($request);

        $this->_config['options'] = array_filter($options + $this->_config['options']);
        if (empty($this->_config['options']['url'])) {
            $this->_config['options']['url'] = [];
        }
        if (!empty($this->_config['options']['model'])) {
            $this->defaultModel($this->_config['options']['model']);
        }
    }

    public function current(?string $model = null): int
    {
        $params = $this->params($model);

        return $params['page'] ?? 1;
    }

    public function total(?string $model = null): int
    {
        $params = $this->params($model);

        return $params['pageCount'] ?? 0;
    }

    public function sortKey(?string $model = null, array $options = []): ?string
    {
        if (empty($options)) {
            $options = $this->params($model);
        }
        if (!empty($options['sort'])) {
            return $options['sort'];
        }

        return null;
    }

    public function sortDir(?string $model = null, array $options = []): string
    {
        $dir = null;

        if (empty($options)) {
            $options = $this->params($model);
        }

        if (!empty($options['direction'])) {
            $dir = strtolower($options['direction']);
        }

        if ($dir === 'desc') {
            return 'desc';
        }

        return 'asc';
    }

    protected function _toggledLink($text, $enabled, $options, $templates): string
    {
        $template = $templates['active'];
        if (!$enabled) {
            $text = $options['disabledTitle'];
            $template = $templates['disabled'];
        }

        if (!$enabled && $text === false) {
            return '';
        }
        $text = $options['escape'] ? h($text) : $text;

        $templater = $this->templater();
        $newTemplates = $options['templates'] ?? false;
        if ($newTemplates) {
            $templater->push();
            $templateMethod = is_string($options['templates']) ? 'load' : 'add';
            $templater->{$templateMethod}($options['templates']);
        }

        if (!$enabled) {
            $out = $templater->format($template, [
                'text' => $text,
            ]);

            if ($newTemplates) {
                $templater->pop();
            }

            return $out;
        }
        $paging = $this->params($options['model']);

        $url = $this->generateUrl(
            ['page' => $paging['page'] + $options['step']],
            $options['model'],
            $options['url']
        );

        $out = $templater->format($template, [
            'url' => $url,
            'text' => $text,
        ]);

        if ($newTemplates) {
            $templater->pop();
        }

        return $out;
    }

    public function prev(string $title = '<< Anterior', array $options = []): string
    {
        $defaults = [
            'url' => [],
            'model' => $this->defaultModel(),
            'disabledTitle' => $title,
            'escape' => true,
        ];
        $options += $defaults;
        $options['step'] = -1;

        $enabled = $this->hasPrev($options['model']);
        $templates = [
            'active' => 'prevActive',
            'disabled' => 'prevDisabled',
        ];

        return $this->_toggledLink($title, $enabled, $options, $templates);
    }

    public function next(string $title = 'Próximo >>', array $options = []): string
    {
        $defaults = [
            'url' => [],
            'model' => $this->defaultModel(),
            'disabledTitle' => $title,
            'escape' => true,
        ];
        $options += $defaults;
        $options['step'] = 1;

        $enabled = $this->hasNext($options['model']);
        $templates = [
            'active' => 'nextActive',
            'disabled' => 'nextDisabled',
        ];

        return $this->_toggledLink($title, $enabled, $options, $templates);
    }

    public function sort(string $key, $title = null, array $options = []): string
    {
        $options += ['url' => [], 'model' => null, 'escape' => true];
        $url = $options['url'];
        unset($options['url']);

        if (empty($title)) {
            $title = $key;

            if (strpos($title, '.') !== false) {
                $title = str_replace('.', ' ', $title);
            }

            $title = __(Inflector::humanize(preg_replace('/_id$/', '', $title)));
        }

        $defaultDir = isset($options['direction']) ? strtolower($options['direction']) : 'asc';
        unset($options['direction']);

        $locked = $options['lock'] ?? false;
        unset($options['lock']);

        $sortKey = (string) $this->sortKey($options['model']);
        $defaultModel = $this->defaultModel();
        $model = $options['model'] ?: $defaultModel;
        [$table, $field] = explode('.', $key . '.');
        if (!$field) {
            $field = $table;
            $table = $model;
        }
        $isSorted = (
            $sortKey === $table . '.' . $field ||
            $sortKey === $model . '.' . $key ||
            $table . '.' . $field === $model . '.' . $sortKey
        );

        $template = 'sort';
        $dir = $defaultDir;
        if ($isSorted) {
            if ($locked) {
                $template = $dir === 'asc' ? 'sortDescLocked' : 'sortAscLocked';
            } else {
                $dir = $this->sortDir($options['model']) === 'asc' ? 'desc' : 'asc';
                $template = $dir === 'asc' ? 'sortDesc' : 'sortAsc';
            }
        }
        if (is_array($title) && array_key_exists($dir, $title)) {
            $title = $title[$dir];
        }

        $paging = ['sort' => $key, 'direction' => $dir, 'page' => 1];

        $vars = [
            'text' => $options['escape'] ? h($title) : $title,
            'url' => $this->generateUrl($paging, $options['model'], $url),
        ];

        return $this->templater()->format($template, $vars);
    }

    public function generateUrl(
        array $options = [],
        ?string $model = null,
        array $url = [],
        array $urlOptions = []
    ): string {
        $urlOptions += [
            'escape' => true,
            'fullBase' => false,
        ];

        return $this->Url->build($this->generateUrlParams($options, $model, $url), $urlOptions);
    }

    public function generateUrlParams(array $options = [], ?string $model = null, array $url = []): array
    {
        $paging = $this->params($model);
        $paging += ['page' => null, 'sort' => null, 'direction' => null, 'limit' => null];

        if (
            !empty($paging['sort'])
            && !empty($options['sort'])
            && strpos($options['sort'], '.') === false
        ) {
            $paging['sort'] = $this->_removeAlias($paging['sort'], $model = null);
        }
        if (
            !empty($paging['sortDefault'])
            && !empty($options['sort'])
            && strpos($options['sort'], '.') === false
        ) {
            $paging['sortDefault'] = $this->_removeAlias($paging['sortDefault'], $model);
        }

        $options += array_intersect_key(
            $paging,
            ['page' => null, 'limit' => null, 'sort' => null, 'direction' => null]
        );

        if (!empty($options['page']) && $options['page'] === 1) {
            $options['page'] = null;
        }

        if (
            isset($paging['sortDefault'], $paging['directionDefault'], $options['sort'], $options['direction'])
            && $options['sort'] === $paging['sortDefault']
            && strtolower($options['direction']) === strtolower($paging['directionDefault'])
        ) {
            $options['sort'] = $options['direction'] = null;
        }
        $baseUrl = $this->_config['options']['url'] ?? [];
        if (!empty($paging['scope'])) {
            $scope = $paging['scope'];
            if (isset($baseUrl['?'][$scope]) && is_array($baseUrl['?'][$scope])) {
                $options += $baseUrl['?'][$scope];
                unset($baseUrl['?'][$scope]);
            }
            $options = [$scope => $options];
        }

        if (!empty($baseUrl)) {
            $url = Hash::merge($url, $baseUrl);
        }

        $url['?'] = $url['?'] ?? [];

        if (!empty($this->_config['options']['routePlaceholders'])) {
            $placeholders = array_flip($this->_config['options']['routePlaceholders']);
            $url += array_intersect_key($options, $placeholders);
            $url['?'] += array_diff_key($options, $placeholders);
        } else {
            $url['?'] += $options;
        }

        $url['?'] = Hash::filter($url['?']);

        return $url;
    }

    protected function _removeAlias(string $field, ?string $model = null): string
    {
        $currentModel = $model ?: $this->defaultModel();

        if (strpos($field, '.') === false) {
            return $field;
        }

        [$alias, $currentField] = explode('.', $field);

        if ($alias === $currentModel) {
            return $currentField;
        }

        return $field;
    }

    public function hasPrev(?string $model = null): bool
    {
        return $this->_hasPage($model, 'prev');
    }

    public function hasNext(?string $model = null): bool
    {
        return $this->_hasPage($model, 'next');
    }

    public function hasPage(int $page = 1, ?string $model = null): bool
    {
        $paging = $this->params($model);
        if ($paging === []) {
            return false;
        }

        return $page <= $paging['pageCount'];
    }

    protected function _hasPage(?string $model, string $dir): bool
    {
        $params = $this->params($model);

        return !empty($params) && $params[$dir . 'Page'];
    }

    public function defaultModel(?string $model = null): ?string
    {
        if ($model !== null) {
            $this->_defaultModel = $model;
        }
        if ($this->_defaultModel) {
            return $this->_defaultModel;
        }

        $params = $this->_View->getRequest()->getAttribute('paging');
        if (!$params) {
            return null;
        }
        [$this->_defaultModel] = array_keys($params);

        return $this->_defaultModel;
    }
    public function counter(string $format = 'pages', array $options = []): string
    {
        $options += [
            'model' => $this->defaultModel(),
        ];

        $paging = $this->params($options['model']);
        if (!$paging['pageCount']) {
            $paging['pageCount'] = 1;
        }

        switch ($format) {
            case 'range':
            case 'pages':
                $template = 'counter' . ucfirst($format);
                break;
            default:
                $template = 'counterCustom';
                $this->templater()->add([$template => $format]);
        }
        $map = array_map([$this->Number, 'format'], [
            'page' => $paging['page'],
            'pages' => $paging['pageCount'],
            'current' => $paging['current'],
            'count' => $paging['count'],
            'start' => $paging['start'],
            'end' => $paging['end'],
        ]);

        $map += [
            'model' => strtolower(Inflector::humanize(Inflector::tableize($options['model']))),
        ];

        return $this->templater()->format($template, $map);
    }

    public function numbers(array $options = []): string
    {
        $defaults = [
            'before' => null, 'after' => null, 'model' => $this->defaultModel(),
            'modulus' => 8, 'first' => null, 'last' => null, 'url' => [],
        ];
        $options += $defaults;

        $params = $this->params($options['model']) + ['page' => 1];
        if ($params['pageCount'] <= 1) {
            return '';
        }

        $templater = $this->templater();
        if (isset($options['templates'])) {
            $templater->push();
            $method = is_string($options['templates']) ? 'load' : 'add';
            $templater->{$method}($options['templates']);
        }

        if ($options['modulus'] !== false && $params['pageCount'] > $options['modulus']) {
            $out = $this->_modulusNumbers($templater, $params, $options);
        } else {
            $out = $this->_numbers($templater, $params, $options);
        }

        if (isset($options['templates'])) {
            $templater->pop();
        }

        return $out;
    }

    protected function _getNumbersStartAndEnd(array $params, array $options): array
    {
        $half = (int) ($options['modulus'] / 2);
        $end = max(1 + $options['modulus'], $params['page'] + $half);
        $start = min($params['pageCount'] - $options['modulus'], $params['page'] - $half - $options['modulus'] % 2);

        if ($options['first']) {
            $first = is_int($options['first']) ? $options['first'] : 1;

            if ($start <= $first + 2) {
                $start = 1;
            }
        }

        if ($options['last']) {
            $last = is_int($options['last']) ? $options['last'] : 1;

            if ($end >= $params['pageCount'] - $last - 1) {
                $end = $params['pageCount'];
            }
        }

        $end = (int) min($params['pageCount'], $end);
        $start = (int) max(1, $start);

        return [$start, $end];
    }

    protected function _formatNumber(StringTemplate $templater, array $options): string
    {
        $vars = [
            'text' => $options['text'],
            'url' => $this->generateUrl(['page' => $options['page']], $options['model'], $options['url']),
        ];

        return $templater->format('number', $vars);
    }

    protected function _modulusNumbers(StringTemplate $templater, array $params, array $options): string
    {
        $out = '';
        $ellipsis = $templater->format('ellipsis', []);

        [$start, $end] = $this->_getNumbersStartAndEnd($params, $options);

        $out .= $this->_firstNumber($ellipsis, $params, $start, $options);
        $out .= $options['before'];

        for ($i = $start; $i < $params['page']; $i++) {
            $out .= $this->_formatNumber($templater, [
                'text' => $this->Number->format($i),
                'page' => $i,
                'model' => $options['model'],
                'url' => $options['url'],
            ]);
        }

        $out .= $templater->format('current', [
            'text' => $this->Number->format($params['page']),
            'url' => $this->generateUrl(['page' => $params['page']], $options['model'], $options['url']),
        ]);

        $start = $params['page'] + 1;
        $i = $start;
        while ($i < $end) {
            $out .= $this->_formatNumber($templater, [
                'text' => $this->Number->format($i),
                'page' => $i,
                'model' => $options['model'],
                'url' => $options['url'],
            ]);
            $i++;
        }

        if ($end !== $params['page']) {
            $out .= $this->_formatNumber($templater, [
                'text' => $this->Number->format($i),
                'page' => $end,
                'model' => $options['model'],
                'url' => $options['url'],
            ]);
        }

        $out .= $options['after'];
        $out .= $this->_lastNumber($ellipsis, $params, $end, $options);

        return $out;
    }

    protected function _firstNumber(string $ellipsis, array $params, int $start, array $options): string
    {
        $out = '';
        $first = is_int($options['first']) ? $options['first'] : 0;
        if ($options['first'] && $start > 1) {
            $offset = $start <= $first ? $start - 1 : $options['first'];
            $out .= $this->first($offset, $options);
            if ($first < $start - 1) {
                $out .= $ellipsis;
            }
        }

        return $out;
    }

    protected function _lastNumber(string $ellipsis, array $params, int $end, array $options): string
    {
        $out = '';
        $last = is_int($options['last']) ? $options['last'] : 0;
        if ($options['last'] && $end < $params['pageCount']) {
            $offset = $params['pageCount'] < $end + $last ? $params['pageCount'] - $end : $options['last'];
            if ($offset <= $options['last'] && $params['pageCount'] - $end > $last) {
                $out .= $ellipsis;
            }
            $out .= $this->last($offset, $options);
        }

        return $out;
    }

    protected function _numbers(StringTemplate $templater, array $params, array $options): string
    {
        $out = '';
        $out .= $options['before'];

        for ($i = 1; $i <= $params['pageCount']; $i++) {
            if ($i === $params['page']) {
                $out .= $templater->format('current', [
                    'text' => $this->Number->format($params['page']),
                    'url' => $this->generateUrl(['page' => $i], $options['model'], $options['url']),
                ]);
            } else {
                $vars = [
                    'text' => $this->Number->format($i),
                    'url' => $this->generateUrl(['page' => $i], $options['model'], $options['url']),
                ];
                $out .= $templater->format('number', $vars);
            }
        }
        $out .= $options['after'];

        return $out;
    }

    public function first($first = '<< Primeiro', array $options = []): string
    {
        $options += [
            'url' => [],
            'model' => $this->defaultModel(),
            'escape' => true,
        ];

        $params = $this->params($options['model']);

        if ($params['pageCount'] <= 1) {
            return '';
        }

        $out = '';

        if (is_int($first) && $params['page'] >= $first) {
            for ($i = 1; $i <= $first; $i++) {
                $out .= $this->templater()->format('number', [
                    'url' => $this->generateUrl(['page' => $i], $options['model'], $options['url']),
                    'text' => $this->Number->format($i),
                ]);
            }
        } elseif ($params['page'] > 1 && is_string($first)) {
            $first = $options['escape'] ? h($first) : $first;
            $out .= $this->templater()->format('first', [
                'url' => $this->generateUrl(['page' => 1], $options['model'], $options['url']),
                'text' => $first,
            ]);
        }

        return $out;
    }

    public function last($last = 'Último >>', array $options = []): string
    {
        $options += [
            'model' => $this->defaultModel(),
            'escape' => true,
            'url' => [],
        ];
        $params = $this->params($options['model']);

        if ($params['pageCount'] <= 1) {
            return '';
        }

        $out = '';
        $lower = (int) $params['pageCount'] - (int) $last + 1;

        if (is_int($last) && $params['page'] <= $lower) {
            for ($i = $lower; $i <= $params['pageCount']; $i++) {
                $out .= $this->templater()->format('number', [
                    'url' => $this->generateUrl(['page' => $i], $options['model'], $options['url']),
                    'text' => $this->Number->format($i),
                ]);
            }
        } elseif ($params['page'] < $params['pageCount'] && is_string($last)) {
            $last = $options['escape'] ? h($last) : $last;
            $out .= $this->templater()->format('last', [
                'url' => $this->generateUrl(['page' => $params['pageCount']], $options['model'], $options['url']),
                'text' => $last,
            ]);
        }

        return $out;
    }

    public function meta(array $options = []): ?string
    {
        $options += [
            'model' => null,
            'block' => false,
            'prev' => true,
            'next' => true,
            'first' => false,
            'last' => false,
        ];

        $model = $options['model'] ?? null;
        $params = $this->params($model);
        $links = [];

        if ($options['prev'] && $this->hasPrev()) {
            $links[] = $this->Html->meta(
                'prev',
                $this->generateUrl(['page' => $params['page'] - 1], null, [], ['escape' => false, 'fullBase' => true])
            );
        }

        if ($options['next'] && $this->hasNext()) {
            $links[] = $this->Html->meta(
                'next',
                $this->generateUrl(['page' => $params['page'] + 1], null, [], ['escape' => false, 'fullBase' => true])
            );
        }

        if ($options['first']) {
            $links[] = $this->Html->meta(
                'first',
                $this->generateUrl(['page' => 1], null, [], ['escape' => false, 'fullBase' => true])
            );
        }

        if ($options['last']) {
            $links[] = $this->Html->meta(
                'last',
                $this->generateUrl(['page' => $params['pageCount']], null, [], ['escape' => false, 'fullBase' => true])
            );
        }

        $out = implode($links);

        if ($options['block'] === true) {
            $options['block'] = __FUNCTION__;
        }

        if ($options['block']) {
            $this->_View->append($options['block'], $out);

            return null;
        }

        return $out;
    }

    public function implementedEvents(): array
    {
        return [];
    }

    public function limitControl(array $limits = [], ?int $default = null, array $options = []): string
    {
        $model = $options['model'] ?? $this->defaultModel();
        unset($options['model']);

        $params = $this->params($model);
        $scope = '';
        if (!empty($params['scope'])) {
            $scope = $params['scope'] . '.';
        }

        if (empty($default)) {
            $default = $params['perPage'] ?? 0;
        }

        if (empty($limits)) {
            $limits = [
                '20' => '20',
                '50' => '50',
                '100' => '100',
            ];
        }
        $out = $this->Form->create(null, ['type' => 'get']);
        $out .= $this->Form->control($scope . 'limit', $options + [
            'type' => 'select',
            'label' => __('Ver'),
            'default' => $default,
            'value' => $this->_View->getRequest()->getQuery('limit'),
            'options' => $limits,
            'onChange' => 'this.form.submit()',
        ]);
        $out .= $this->Form->end();

        return $out;
    }
}
