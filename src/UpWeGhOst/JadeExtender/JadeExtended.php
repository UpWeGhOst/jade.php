<?php

// TODO: Enhance

namespace UpWeGhOst\JadeExtender;

use Everzet\Jade\Dumper\DumperInterface;
use Everzet\Jade\Jade;
use Everzet\Jade\Parser;

class JadeExtended extends Jade {

	public static function create(Parser $parser, DumperInterface $dumper, $cache = null) {
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