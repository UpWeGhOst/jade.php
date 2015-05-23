<?php

// TODO: Enhance

namespace UpWeGhOst\JadeExtender;

use Everzet\Jade\Dumper\DumperInterface;
use Everzet\Jade\Filter\CDATAFilter;
use Everzet\Jade\Filter\CSSFilter;
use Everzet\Jade\Filter\JavaScriptFilter;
use Everzet\Jade\Filter\PHPFilter;
use Everzet\Jade\Jade;
use Everzet\Jade\Lexer\Lexer;
use Everzet\Jade\Parser;
use Everzet\Jade\Visitor\AutotagsVisitor;
use UpWeGhOst\JadeExtender\Dumper\PHPDumperExtended;

class JadeExtended extends Jade {

	public static function create(Parser $parser = null, DumperInterface $dumper = null, $cache = null) {

		if ($parser === null || $dumper === null)
			return new self(
				new Parser(new Lexer()),
				PHPDumperExtended::create()
					->registerVisitor('tag', new AutotagsVisitor())
					->registerFilter('javascript', new JavaScriptFilter())
					->registerFilter('cdata', new CDATAFilter())
					->registerFilter('php', new PHPFilter())
					->registerFilter('style', new CSSFilter())
			);

		return new self($parser, $dumper, $cache);

	}

	public function render($template, array $data) {

		$source = $this->getInputSource($template);
		foreach ($data as $key => $value) {
			$source = str_replace('{{' . $key . '}}', $value, $source);
		}
		$parsed = $this->parser->parse($source);

		return $this->dumper->dump($parsed);

	}

}