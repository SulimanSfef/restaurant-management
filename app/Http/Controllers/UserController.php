<?php
// app/Http/Controllers/UserController.php
namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserRequest;
use App\Services\UserService;
use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    use ApiResponseTrait;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function destroy(DeleteUserRequest $request, $id)
    {
        try {
            $this->userService->deleteUser($id);
            return $this->successResponse(null, 'تم حذف المستخدم بنجاح');
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('المستخدم غير موجود', 404);
        } catch (\Exception $e) {
            return $this->errorResponse('حدث خطأ أثناء حذف المستخدم', 500);
        }
    }
}
