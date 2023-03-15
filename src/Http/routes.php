<?php

use DeMemory\DcatMailTool\Http\DcatMailToolController;
use Illuminate\Support\Facades\Route;

Route::get('dcat-mail-tool', DcatMailToolController::class.'@index');
