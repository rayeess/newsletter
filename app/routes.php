<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::controller('subscribers', 'SubscribersController');

//This code will trigger the push request
Route::get('queue/process',function()
{
	Queue::push('SendEmail');
	return 'Queue Processed Successfully!!';
});

Route::get('queue/test',function()
{
    Mail::send('emails.test', array(), function($message)
            {
                $message->to('p_rayees@hotmail.co.uk', 'Rayees')->subject('Testing Iron');
            });

    return 'Mail sent';
});

Route::get('queue/processtest',function()
{
    Queue::push(function($job) 
    {
            Mail::send('emails.test', array(), function($message)
            {
                $message->to('p_rayees@hotmail.co.uk', 'Rayees')->subject('Testing Iron process');
            });

            $job->delete();
    });

    return 'Queue Processed Successfully!';
});

//When the push driver sends us back, we will have to marshal and process the queue.
Route::post('queue/push',function()
{
	return Queue::marshal();
});

//When the queue is pushed and waiting to be marshalled, we should assign a Class to make the job done
Class SendEmail {

	public function fire($job,$data)
	{
    	//We first get the all data from our subscribers database
        $subscribers = Subscriber::all();
        foreach ($subscribers as $each) {
        	//Now we send an email to each subscriber
        	Mail::send('emails.test', array('email' => $each->email), function($message) use ($each) {
                $message->to($each->email)->subject('Testing Iron Queue');
            });
        }
        
        //File::append('/var/www/newsletter/public/queue.txt', $data['string'].PHP_EOL);

        $job->delete();
    }
}