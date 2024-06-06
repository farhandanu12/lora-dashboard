use App\Http\Controllers\Api\UplinkController;

Route::get('/uplinks/chripstack', [UplinkController::class, 'fetchData']);
