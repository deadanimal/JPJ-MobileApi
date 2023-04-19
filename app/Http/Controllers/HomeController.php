<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Storage;
use PDF;
use Illuminate\Support\Str;
use App\Models\User;

class HomeController extends Controller
{
	use AuthenticatesUsers;

	protected $redirectTo = '/';

	public function index(Request $request)
	{

		$app_name = config('app.name');
		$title = ucwords($app_name);
		$image = "/images/og.png";
		$description = "Welcome to $title.";


		$data = [
			'title' => $title,
			'image' => $image,
			'description' => $description,
		];


		return view('welcome', $data);
	}

	// @override
	protected function loggedOut(Request $request)
	{
		return redirect('/');
	}

	private function getPDF()
	{
		// $logo = $this->imageService->encode_img_base64(public_path("images/form-template-header.png"));
		// $user = Auth::user();
		$type = "receipt";
		$content = "Test pdf output";

		$pdf = PDF::loadView('print.' . $type, compact('content'));

		return $pdf;
	}

	public function pdfCheck()
	{
		$directory = 'print';
		// self::cleanTempPrintDirectory();

		$application_name = config('app.default_application_name');

		$type = "Receipt";
		$random = time() . Str::random(10);

		$name = $type . "_" . $random . '.pdf';

		$pdf = $this->getPDF();

		$output = $pdf->output();

		Storage::disk('public')->put($directory . '/' . $name, $output);
		
		// Storage::disk('sftp')->put('/usr/share/nginx/html/receipt/' . $name, $output);
		
		return redirect(Storage::disk('public')->url($directory . '/' . $name));
		// return true;
	}

	public function cleanTempPrintDirectory()
	{
		$directory = 'print';

		$files = Storage::disk('public')->files($directory);
		return Storage::disk('public')->delete($files);
	}
}
