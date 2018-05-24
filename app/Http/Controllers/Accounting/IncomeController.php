<?php
namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IncomeController extends Controller
{
    public function index() {
		$data['title']       = 'การจัดการเก็บรายได้';
		$data['main_menu']   = 'การจัดการเก็บรายได้';
		return view('admin.Accounting.income', $data);
    }
}
