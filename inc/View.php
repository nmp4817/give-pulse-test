<?php

class View
{
	public function render($view)
	{
		require($view);
	}
}