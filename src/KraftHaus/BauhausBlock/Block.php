<?php

namespace KraftHaus\BauhausBlock;

/**
 * This file is part of the KraftHaus BauhausBlock package.
 *
 * (c) KraftHaus <hello@krafthaus.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use KraftHaus\BauhausBlock\Resolver\OptionResolver;
use Illuminate\Support\Facades\Cache;

/**
 * Class Block
 * @package KraftHaus\BauhausBlock
 * @abstract
 */
abstract class Block
{

	/**
	 * Holds the OptionResolver object.
	 * @var OptionResolver
	 */
	protected $optionResolver;

	/**
	 * Holds the cache ttl.
	 * @var integer
	 */
	protected $ttl = null;

	/**
	 * When overridden, this path will be used to render the view.
	 * @var null
	 */
	protected $view = null;

	/**
	 * Configure the current block instance.
	 *
	 * @param  OptionResolver $resolver
	 *
	 * @access public
	 * @return mixed
	 * @abstract
	 */
	abstract public function configure(OptionResolver $resolver);

	/**
	 * Execute/setup the current block instance.
	 *
	 * @access public
	 * @return mixed
	 * @abstract
	 */
	abstract public function execute();

	/**
	 * Set the OptionResolver object.
	 *
	 * @param  OptionResolver $optionResolver
	 *
	 * @access public
	 * @return Builder
	 */
	public function setOptionResolver($optionResolver)
	{
		$this->optionResolver = $optionResolver;
		return $this;
	}

	/**
	 * Get the OptionResolver object.
	 *
	 * @access public
	 * @return OptionResolver
	 */
	public function getOptionResolver()
	{
		return $this->optionResolver;
	}

	/**
	 * Render the block.
	 *
	 * @access public
	 * @return View
	 */
	public function render()
	{
		if ($this->getView() === null) {
			$view = get_class($this);
			$view = Str::snake($view);

			$this->setView('blocks.' . $view);
		}

		return View::make($this->getView())
			->with('options', $this->getOptionResolver());
	}

	/**
	 * Set the cache ttl.
	 *
	 * @param  int $ttl
	 *
	 * @access public
	 * @return $this
	 */
	public function setTtl($ttl)
	{
		$this->ttl = (int) $ttl;
		return $this;
	}

	/**
	 * Get the cache ttl.
	 *
	 * @access public
	 * @return int
	 */
	public function getTtl()
	{
		return $this->ttl;
	}

	/**
	 * Set the view path.
	 *
	 * @param  string $view
	 *
	 * @access public
	 * @return $this
	 */
	public function setView($view)
	{
		$this->view = $view;
		return $this;
	}

	/**
	 * Get the view path.
	 *
	 * @access public
	 * @return null|string
	 */
	public function getView()
	{
		return $this->view;
	}

}