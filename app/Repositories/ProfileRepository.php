<?php

namespace App\Repositories;

// use App\Models\BranchModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ProfileRepository extends BaseRepository
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }
    // public function searchByName($name)
    // {
    //     try {
    //         return $this->branchModel->select('branchs.id', 'branchs.name', 'branchs.phone_number', 'branchs.email', 'branchs.address', 'branchs.note')
    //             ->where('branchs.name', 'like', '%' . $name . '%')
    //             ->where('deleted_at', '=', null)
    //             ->orderBy('branchs.id', 'desc')
    //             ->paginate(10);
    //     } catch (Exception $e) {
    //         return $e->getMessage();
    //     }
    // }
    // public function createBranch($data)
    // {
    //     try {
    //         $this->branchModel->create([
    //             'name' => $data['name'],
    //             'email' => $data['email'],
    //             'phone_number' => $data['phone_number'],
    //             'address' => $data['address'],
    //             'note' => $data['note'],
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);
    //     } catch (Exception $e) {
    //         return $e->getMessage();
    //     }
    // }
    // public function getBranchName()
    // {
    //     try {
    //         return $this->branchModel->select('branchs.id', 'branchs.name')
    //             ->where('deleted_at', '=', null)
    //             ->orderBy('branchs.id', 'desc')
    //             ->get();
    //     } catch (Exception $e) {
    //         return $e->getMessage();
    //     }
    // }

    // public function getAllBranch()
    // {
    //     try {
    //         return $this->branchModel->select('branchs.id', 'branchs.name', 'branchs.phone_number', 'branchs.email', 'branchs.address', 'branchs.note', 'branchs.deleted_at')
    //             ->where('deleted_at', '=', null)
    //             ->orderBy('branchs.id', 'asc')
    //             ->paginate(10);
    //     } catch (Exception $e) {
    //         return $e->getMessage();
    //     }
    // }

    // public function getBranchById($id)
    // {
    //     try {
    //         return $this->branchModel->select('branchs.id', 'branchs.name', 'branchs.phone_number', 'branchs.email', 'branchs.address', 'branchs.note', 'branchs.deleted_at')
    //             ->where('branchs.id', $id)
    //             ->where('deleted_at', '=', null)
    //             ->first();
    //     } catch (Exception $e) {
    //         return $e->getMessage();
    //     }
    // }
    public function updateProfile($id, $data)
    {
        try {
            return $this->userModel->where('id', $id)->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'address' => $data['address'],
                'note' => $data['note'],
                'updated_at' => now(),
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
