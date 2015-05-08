<?php namespace ImagesManager\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if(config('app.debug'))
		{
			return parent::render($request, $e);
		}
		elseif ($this->isHttpException($e))
		{
			return $this->renderHttpException($e);
		}
		else
		{
			return redirect('/')->withErrors('Unexpected Error. Try later.');
		}
	}

	protected function renderHttpException(HttpException $e)
	{
		$status = $e->getStatusCode();

		if (view()->exists("errors.{$status}"))
		{
			return response()->view("errors.{$status}", [], $status);
		}
		else
		{
			return response()->view("errors.default", [], $status);
		}
	}

}
