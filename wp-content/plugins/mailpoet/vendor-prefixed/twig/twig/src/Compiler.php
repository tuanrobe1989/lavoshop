<?php
namespace MailPoetVendor\Twig;
if (!defined('ABSPATH')) exit;
use MailPoetVendor\Twig\Node\Node;
class Compiler
{
 private $lastLine;
 private $source;
 private $indentation;
 private $env;
 private $debugInfo = [];
 private $sourceOffset;
 private $sourceLine;
 private $varNameSalt = 0;
 public function __construct(Environment $env)
 {
 $this->env = $env;
 }
 public function getEnvironment()
 {
 return $this->env;
 }
 public function getSource()
 {
 return $this->source;
 }
 public function compile(Node $node, $indentation = 0)
 {
 $this->lastLine = null;
 $this->source = '';
 $this->debugInfo = [];
 $this->sourceOffset = 0;
 // source code starts at 1 (as we then increment it when we encounter new lines)
 $this->sourceLine = 1;
 $this->indentation = $indentation;
 $this->varNameSalt = 0;
 $node->compile($this);
 return $this;
 }
 public function subcompile(Node $node, $raw = \true)
 {
 if (\false === $raw) {
 $this->source .= \str_repeat(' ', $this->indentation * 4);
 }
 $node->compile($this);
 return $this;
 }
 public function raw($string)
 {
 $this->source .= $string;
 return $this;
 }
 public function write(...$strings)
 {
 foreach ($strings as $string) {
 $this->source .= \str_repeat(' ', $this->indentation * 4) . $string;
 }
 return $this;
 }
 public function string($value)
 {
 $this->source .= \sprintf('"%s"', \addcslashes($value, "\0\t\"\$\\"));
 return $this;
 }
 public function repr($value)
 {
 if (\is_int($value) || \is_float($value)) {
 if (\false !== ($locale = \setlocale(\LC_NUMERIC, '0'))) {
 \setlocale(\LC_NUMERIC, 'C');
 }
 $this->raw(\var_export($value, \true));
 if (\false !== $locale) {
 \setlocale(\LC_NUMERIC, $locale);
 }
 } elseif (null === $value) {
 $this->raw('null');
 } elseif (\is_bool($value)) {
 $this->raw($value ? 'true' : 'false');
 } elseif (\is_array($value)) {
 $this->raw('array(');
 $first = \true;
 foreach ($value as $key => $v) {
 if (!$first) {
 $this->raw(', ');
 }
 $first = \false;
 $this->repr($key);
 $this->raw(' => ');
 $this->repr($v);
 }
 $this->raw(')');
 } else {
 $this->string($value);
 }
 return $this;
 }
 public function addDebugInfo(Node $node)
 {
 if ($node->getTemplateLine() != $this->lastLine) {
 $this->write(\sprintf("// line %d\n", $node->getTemplateLine()));
 $this->sourceLine += \substr_count($this->source, "\n", $this->sourceOffset);
 $this->sourceOffset = \strlen($this->source);
 $this->debugInfo[$this->sourceLine] = $node->getTemplateLine();
 $this->lastLine = $node->getTemplateLine();
 }
 return $this;
 }
 public function getDebugInfo()
 {
 \ksort($this->debugInfo);
 return $this->debugInfo;
 }
 public function indent($step = 1)
 {
 $this->indentation += $step;
 return $this;
 }
 public function outdent($step = 1)
 {
 // can't outdent by more steps than the current indentation level
 if ($this->indentation < $step) {
 throw new \LogicException('Unable to call outdent() as the indentation would become negative.');
 }
 $this->indentation -= $step;
 return $this;
 }
 public function getVarName()
 {
 return \sprintf('__internal_compile_%d', $this->varNameSalt++);
 }
}
\class_alias('MailPoetVendor\\Twig\\Compiler', 'MailPoetVendor\\Twig_Compiler');
