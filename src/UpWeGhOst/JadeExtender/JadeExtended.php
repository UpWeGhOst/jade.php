<?php

// TODO: Enhance

namespace UpWeGhOst\JadeExtender;

use Everzet\Jade\Jade;

class JadeExtended extends Jade {

	public function render($template, array $data) {

		$source = $this->getInputSource($template);
		foreach ($data as $key => $value) {
			$source = str_replace('{{' . $key . '}}', $value, $source);
		}
		$parsed = $this->parser->parse($source);

		return $this->dumper->dump($parsed);

	}

}