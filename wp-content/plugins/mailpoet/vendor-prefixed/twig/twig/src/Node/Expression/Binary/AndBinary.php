<?php
namespace MailPoetVendor\Twig\Node\Expression\Binary;
if (!defined('ABSPATH')) exit;
use MailPoetVendor\Twig\Compiler;
class AndBinary extends AbstractBinary
{
 public function operator(Compiler $compiler)
 {
 return $compiler->raw('&&');
 }
}
\class_alias('MailPoetVendor\\Twig\\Node\\Expression\\Binary\\AndBinary', 'MailPoetVendor\\Twig_Node_Expression_Binary_And');
