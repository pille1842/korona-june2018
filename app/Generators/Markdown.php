<?php

namespace Korona\Generators;

use Parsedown;

class Markdown extends Parsedown
{
    protected $environment;

    public function __construct($environment = [])
    {
        $this->InlineTypes['{'][] = 'VariableInput';
        $this->inlineMarkerList  .= '{';
        $this->setEnvironment($environment);
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }

    public function getVariable($variable)
    {
        return isset($this->environment[$variable]) ? $this->environment[$variable] : null;
    }

    public function setVariable($variable, $value)
    {
        $this->environment[$variable] = $value;
    }

    protected function inlineVariableInput($excerpt)
    {
        if (preg_match('/^{(\w+)}/', $excerpt['text'], $matches)) {
            if (isset($this->environment[$matches[1]])) {
                $replacement = $this->environment[$matches[1]];
            } else {
                $replacement = '';
            }
            return [
                'extent' => strlen($matches[0]),
                'element' => [
                    'name' => 'span',
                    'text' => $replacement
                ]
            ];
        }
    }
}
