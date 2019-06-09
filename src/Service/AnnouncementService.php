<?php 

namespace App\Service;

use App\Service\AnnouncementService;
use App\Repository\AnnouncementRepository;

class AnnouncementService
{
    private $repository;

    public function __construct( AnnouncementRepository $repository) {
        $this->repository = $repository;
    }

    public function getAll(){
        return $this->repository->findAll();
    }

    public function getOne($id){
        return $this->repository->find($id);
    }

    public function search($str){
        return $this->repository->search($str);
    }
}