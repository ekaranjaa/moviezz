<?php

class Upload
{
    private $validtypes;
    private $path = __DIR__ . '/../../../public/images/';
    public $fb;

    public function __construct()
    {
        $this->validtypes = ['jpeg', 'png', 'jpg', 'gif'];
    }

    public function upload_image(array $file)
    {
        $file_name = $file['name'];
        $file_name = explode('.', $file_name);
        $file_name[0] = rand(0, 1000);
        $target_file = $this->path . $file_name[0] . '.' . $file_name[1];

        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $size = $file['size'];
        $file_error = $file['error'];

        if (getimagesize($file['tmp_name'])) {
            if (file_exists($target_file)) {
                $this->fb = 'File already exists';
            } else {
                if (in_array($file_type, $this->validtypes)) {
                    if ($size > 5000000) {
                        $this->fb = 'File size is too large';
                        $fb = false;
                    } else {
                        if (!empty($file_error)) {
                            $this->fb = 'An error occured while uploading the file';
                            $fb = false;
                        } else {

                            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                                $this->fb = implode('.', $file_name);
                                $fb = true;
                            } else {
                                $this->fb = 'Error uploading file';
                                $fb = false;
                            }
                        }
                    }
                } else {
                    $this->fb = 'Make sure the file type is one of ' . implode(',', $this->validtypes);
                    $fb = false;
                }
            }
        } else {
            $this->fb = 'Oops! Looks like the file is not a valid image';
            $fb = false;
        }

        return $fb;
    }

    public function remove_image(string $filename)
    {
        $target_file = $this->path . $filename;

        if (file_exists($target_file)) {
            if (unlink($target_file)) {
                $fb = true;
            } else {
                $fb = false;
                $this->fb = 'Error deleting file';
            }
        } else {
            $fb = true;
        }

        return $fb;
    }
}
