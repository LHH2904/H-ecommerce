<?php
// app/Services/BranchService.php

namespace App\Services;

use App\Repositories\ProfileRepository;
use Exception;

class ProfileService
{
    protected $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    // public function createBranch($data)
    // {
    //     try {
    //         return $this->branchRepository->createBranch($data);
    //     } catch (Exception $e) {
    //         return $e->getMessage();
    //     }
    // }

    // public function getBranchById($id)
    // {
    //     return $this->branchRepository->getBranchById($id);
    // }

    public function updateProfile($id, $data)
    {
        return $this->profileRepository->updateProfile($id, $data);
    }

    // public function deleteBranch($id)
    // {
    //     return $this->branchRepository->deleteBranch($id);
    // }

    // public function searchBranchByName($searchTerm)
    // {
    //     return $this->branchRepository->searchByName($searchTerm);
    // }

    // public function getAllBranches()
    // {
    //     return $this->branchRepository->getAllBranch();
    // }
}
