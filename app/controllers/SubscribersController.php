<?php

class SubscribersController extends BaseController {

	//The method to show the form to add a new feed
	public function getIndex()
	{
		return View::make('subscribe_form');
	}


}
