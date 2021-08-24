<?php


namespace App\Services;


use Illuminate\Support\Facades\Auth;

class UploadService
{
    protected string $uploadPath;

    public function __construct(){
        $this->setUploadPath('public/images');
    }

    /**
     * @param string $uploadPath
     */
    public function setUploadPath(string $uploadPath): void
    {
        $this->uploadPath = $uploadPath . '/' . Auth::id() ;
    }

    /**
     * @return string
     */
    public function getUploadPath(): string
    {
        return $this->uploadPath;
    }
}
