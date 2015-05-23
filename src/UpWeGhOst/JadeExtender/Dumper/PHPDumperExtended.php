<?php

namespace UpWeGhOst\JadeExtender\Dumper;

use Everzet\Jade\Dumper\PHPDumper;
use Everzet\Jade\Filter\FilterInterface;
use Everzet\Jade\Visitor\VisitorInterface;

class PHPDumperExtended extends PHPDumper {

	public static function create() {
		return new self();
	}

	public function registerVisitor($name, VisitorInterface $visitor)
	{
		$names = array_keys($this->visitors);

		if (!in_array($name, $names)) {
			throw new \InvalidArgumentException(sprintf('Unsupported node type given "%s". Use %s.',
				$name, implode(', ', $names)
			));
		}

		$this->visitors[$name][] = $visitor;
		return $this;
	}

	public function registerFilter($alias, FilterInterface $filter)
	{
		if (isset($this->filters[$alias])) {
			throw new \InvalidArgumentException(sprintf('Filter with alias %s is already registered', $alias));
		}

		$this->filters[$alias] = $filter;
		return $this;
	}

}