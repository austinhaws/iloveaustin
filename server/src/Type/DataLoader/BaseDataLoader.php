<?php

namespace ILoveAustin\Type\DataLoader;

use ILoveAustin\Context\Context;

abstract class BaseDataLoader
{
	/** @var Context access to services; loaders are not services so should not call daos directly (security matters!) */
	protected $context;
	/** @var mixed[] the ids for which to gather children */
	protected $parentIds = [];
	/** @var array each loader will use this loader differently to load children value(s) for a parent id */
	protected $buffer = [];

	public function __construct(Context $context)
	{
		$this->context = $context;
	}

	/**
	 * loads all the children for all the parentIds in to a buffered
	 * storage for use later by getChildByParentId
	 */
	abstract public function loadBuffered();

	/**
	 * load parent id in to the list of parent ids for which to fetch data
	 *
	 * @param mixed $parentId
	 */
	public function addParentId($parentId)
	{
		$this->parentIds[] = $parentId;
	}

	/**
	 * returns child(s) for a given parent id
	 *
	 * @param mixed $parentId
	 * @return mixed|null
	 */
	public function getChildByParentId($parentId)
	{
		return $this->buffer[$parentId] ?? null;
	}

}
