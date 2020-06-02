<?php

class ImageHelper extends Helper
{
    private $validtypes;
    private $path;
    public $fb;

    public function __construct($destination)
    {
        $this->validtypes = ['jpeg', 'png', 'jpg', 'gif'];
        $this->path = __DIR__ . '/../../public/images/' . $destination . '/';
    }

    public function uploadImage(array $file, string $filename = '')
    {
        $file_name = $file['name'];
        $array_file_name = explode('.', $file_name);
        $new_file_name = !empty($filename) ? $filename : rand(0, 1000);
        $file_name = str_replace($array_file_name[0], $new_file_name, $file_name);
        $target_file = $this->path . $file_name;

        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $size = $file['size'];
        $file_error = $file['error'];

        if (getimagesize($file['tmp_name'])) {
            if (file_exists($target_file)) {
                $this->removeImage($this->path . $target_file);
            }

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
                            $this->fb = $file_name;
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
        } else {
            $this->fb = 'Oops! Looks like the file is not a valid image';
            $fb = false;
        }

        return $fb;
    }

    public function renameImage(string $oldname, string $newname)
    {
        $array_file_name = explode('.', $oldname);
        $oldname = $this->path . $oldname;
        $file_extension = $array_file_name[1];
        $filename = $newname . '.' . $file_extension;
        $newname = $this->path . $newname . '.' . $file_extension;

        if (rename($oldname, $newname)) {
            $fb = true;
            $this->fb = $filename;
        } else {
            $fb = false;
            $this->fb = 'Error renaming file';
        }

        return $fb;
    }

    public function removeImage(string $filename)
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
