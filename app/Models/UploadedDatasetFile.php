<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedDatasetFile extends Model
{
    use HasFactory;

    protected $table = 'uploaded_dataset_files';  //ref: https://laravel.com/docs/8.x/eloquent
}
