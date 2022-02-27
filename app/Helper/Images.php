<?php
    if (! function_exists('temporaryImageUpload')) {
        function temporaryImageUpload($inputImage)
        {
            $today = date('Y-m-d');
            $today = strtotime($today);
            $path = 'd/i/'.$today;
            $storagePath = 'public/'.$path;
            $storedImage = $inputImage->store($storagePath);
            $imagePath = '/'.str_replace("public", 'storage', $storedImage);
            return $imagePath;
        }
    }

    if (! function_exists('removeTemporaryImage')) {
        function removeTemporaryImage($imageUrl)
        {
            $imageUrl = str_replace('storage', 'public', $imageUrl);

            $sourceImageArr = explode('/', $imageUrl);
            $sourceImageName = $sourceImageArr[3] ?? null;
            if ($sourceImageName == null || $sourceImageName != 'draft') return false;
            if(Storage::exists($imageUrl)) {
                Storage::delete( $imageUrl);
                return true;
            }
            return false;
        }
    }

    if (! function_exists('imageMove')) {
        function imageMove($sourceImage, $folderName = 'default', $imageStoreTypes = ['image_path', 'compressed_image_path', 'thumbs_image_path'], $customWidth = 300, $customHeight = 300)
        {
            $sourceImage = str_replace("storage", 'public', $sourceImage);
            $sourceImageArr = explode('/', $sourceImage);
            $sourceImageName = end($sourceImageArr);
            $today = date('Y-m-d');
            $today = strtotime($today);
            
            $imagePath = [];
            foreach ($imageStoreTypes as $type) {
                $typeFolder = '';
                foreach (preg_split('#[^a-z]+#i', $type, -1, PREG_SPLIT_NO_EMPTY) as $word) {
                    $typeFolder .= $word[0];
                }
                $path = 'u/i/'.substr($folderName, 0, 3).'/'.$today.'/'.$typeFolder;
                $storagePath = 'public/'.$path.'/'.$sourceImageName;

                $image = Image::make(Storage::get($sourceImage));
                
                $mime = $image->mime();  //edited due to updated to 2.x
                if ($mime == 'image/jpeg')
                    $extension = 'jpg';
                elseif ($mime == 'image/png')
                    $extension = 'png';
                elseif ($mime == 'image/gif')
                    $extension = 'gif';
                else
                    $extension = 'jpg';

                if(Storage::exists($storagePath)) {
                    Storage::delete( $storagePath);
                }
                switch ($type) {
                    case 'image_path':
                        Storage::copy($sourceImage, $storagePath);  
                        break;
                    case 'custom_compressed':
                        if ($image->mime() == 'image/gif') {
                            Storage::copy($sourceImage, $storagePath);
                            break;
                        }
                        $image->resize($customWidth, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        Storage::put($storagePath, (string) $image->encode('webp', 75));
                        
                        $image = Image::make(Storage::get($sourceImage));
                        $image->resize($customWidth*1.75, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $safariStoragePath = 'public/'.$path.'/sa/'.$sourceImageName;
                        Storage::put($safariStoragePath, (string) $image->encode($extension, 90));
                        break;
                    case 'resize_compressed':
                        if ($image->mime() == 'image/gif') {
                            Storage::copy($sourceImage, $storagePath);
                            break;
                        }
                        $image->resize($customWidth, $customHeight);
                        Storage::put($storagePath, (string) $image->encode('webp', 75));

                        $image = Image::make(Storage::get($sourceImage));
                        $image->resize($customWidth*1.75, $customHeight*1.75);
                        $safariStoragePath = 'public/'.$path.'/sa/'.$sourceImageName;
                        Storage::put($safariStoragePath, (string) $image->encode($extension, 90));
                        break;
                    case 'compressed_image_path':
                        if ($image->mime() == 'image/gif') {
                            Storage::copy($sourceImage, $storagePath);
                            break;
                        }
                        $image->resize(640, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        Storage::put($storagePath, (string) $image->encode('webp', 75));
                        
                        $image = Image::make(Storage::get($sourceImage));
                        $image->resize(960, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $safariStoragePath = 'public/'.$path.'/sa/'.$sourceImageName;
                        Storage::put($safariStoragePath, (string) $image->encode($extension, 90));
                        break;
                    case 'thumbs_image_path':
                        if ($image->mime() == 'image/gif') {
                            Storage::copy($sourceImage, $storagePath);
                            break;
                        }
                        $image->resize(200, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        Storage::put($storagePath, (string) $image->encode('webp', 75));
                        
                        $image = Image::make(Storage::get($sourceImage));
                        $image->resize(300, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $safariStoragePath = 'public/'.$path.'/sa/'.$sourceImageName;
                        Storage::put($safariStoragePath, (string) $image->encode($extension, 90));
                        break;
                    default:
                        Storage::copy($sourceImage, $storagePath);  
                        break;
                }
                $imagePath [$type] = '/'.str_replace("public", 'storage', $storagePath);
            }
            
            Storage::delete( $sourceImage);
            return $imagePath;
        }
    }

    if (! function_exists('imageDelete')) {
        function imageDelete($imageUrl, $permanentDelete = false)
        {
            $imageUrl = str_replace('storage', 'public', $imageUrl);
            $trashPath = str_replace('u', 't', $imageUrl);
            if(Storage::exists($imageUrl)) {
                if ($permanentDelete) {
                    Storage::delete( $imageUrl);
                } else {
                    Storage::move($imageUrl, $trashPath); 
                }   
                return true;
            }
            return false;
        }
    }

    if (! function_exists('temporaryImageClone')) {
        function temporaryImageClone($sourceImage)
        {
            $sourceImageArr = explode('/', $sourceImage);
            if($sourceImageArr[1] != 'storage') {
                $sourceImage = '/storage/'.$sourceImage;
            }
            $sourceImage = str_replace("storage", 'public', $sourceImage);
            $sourceImageName = end($sourceImageArr);
            $extArr = explode('.', $sourceImageName);
            $storeImageName = Uuid::generate()->string.'.'.end($extArr);

            $today = date('Y-m-d');
            $today = strtotime($today);
            $path = 'd/i/'.$today;
            $storagePath = 'public/'.$path.'/'.$storeImageName;
            if(Storage::exists($storagePath)) {
                Storage::delete( $storagePath);
            }
            Storage::copy($sourceImage, $storagePath);
            $imagePath = '/'.str_replace("public", 'storage', $storagePath);
            return $imagePath;
        }
    }
    if (! function_exists('temporaryImageUploadFromUrl')) {
        function temporaryImageUploadFromUrl($url)
        {
            $info = pathinfo($url);
            $extArr = explode('.', $info['basename']);
            $storeImageName = Uuid::generate()->string.'.'.end($extArr);
            $inputImage = file_get_contents($url);
            $today = date('Y-m-d');
            $today = strtotime($today);
            $path = 'd/i/'.$today;
            $storagePath = 'public/'.$path;

            Storage::put($storagePath.'/'.$storeImageName, $inputImage);
            $storedImage = $storagePath.'/'.$storeImageName;
            $imagePath = '/'.str_replace("public", 'storage', $storedImage);
            return $imagePath;
        }
    }