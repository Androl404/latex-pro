<?php

function rrmdir($dir)
{
    if (!is_dir($dir)) {
        throw new InvalidArgumentException("$dir must be a directory");
    }
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . "/" . $object))
                    rrmdir($dir . DIRECTORY_SEPARATOR . $object);
                else
                    unlink($dir . DIRECTORY_SEPARATOR . $object);
            }
        }
        return rmdir($dir);
    }
}

function createFile(string $path, int $projectId)
{
    chdir(__DIR__ . "/../../");
    if (!is_file($path)) {
        if (!file_put_contents("projects/$projectId/$path", " \n", LOCK_EX)) {
            http_response_code(502);
            echo "Something went wrong";
            exit();
        }
    } else {
        http_response_code(400);
        echo "File already exits";
        exit();
    }
}

function createDir(string $dirs, int $projectId)
{
    chdir(__DIR__ . "/../../");
    $path = "projects/$projectId/$dirs";
    if (!is_dir($path)) {
        if (!mkdir($path, 0755, true)) {
            http_response_code(502);
            echo "Something went wrong";
            exit();
        }
    }
}

function dirToArray(string $dir)
{
    chdir(__DIR__ . "/../../");
    $result = array();
    $cdir = scandir($dir);
    foreach ($cdir as $key => $value) {
        if (!in_array($value, array(".", ".."))) {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            } else {
                $result[] = $value;
            }
        }
    }
    return $result;
}

function getFiles(array $dir, int $projectId, string $prefixe = "")
{
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    chdir(__DIR__ . "/../../");
    $html_files = "";
    $html_folder = "";
    foreach ($dir as $key => $values) {
        if (!is_array($values)) {
            if (empty($prefixe)) {
                if (explode("/", finfo_file($finfo, "projects/$projectId/$values"))[0] === 'text') {
                    $html_files .= "<li><a href='edit.php?id_project=$projectId&file=$values'><div><i class='bx bxs-file'></i><span>$values</span></div></a></li>";
                } elseif (finfo_file($finfo, "projects/$projectId/$values") === "application/pdf") {
                    $html_files .= "<li><a href='projects/$projectId/$values' target='_blank'><div><i class='bx bxs-file-pdf'></i><span>$values</span></div></a></li>";
                } else {
                    $html_files .= "<li><a href='projects/$projectId/$values' target='_blank'><div><i class='bx bxs-file-blank'></i><span>$values</span></div></a></li>";
                }
            } else {
                if (explode("/", finfo_file($finfo, "projects/$projectId/$prefixe/$values"))[0] === 'text') {
                    $html_files .= "<li><a href='edit.php?id_project=$projectId&file=$prefixe/$values'><div><i class='bx bxs-file'></i><span>$values</span></div></a></li>";
                } elseif (finfo_file($finfo, "projects/$projectId/$prefixe/$values") === "application/pdf") {
                    $html_files .= "<li><a href='projects/$projectId/$prefixe/$values' target='_blank'><div><i class='bx bxs-file-pdf'></i><span>$values</span></div></a></li>";
                } else {
                    $html_files .= "<li><a href='projects/$projectId/$prefixe/$values' target='_blank'><div><i class='bx bxs-file-blank'></i><span>$values</span></div></a></li>";
                }
            }
        } else {
            $next_dir = $prefixe . DIRECTORY_SEPARATOR . $key;
            $html_folder .= "<li><div class='tree-directory'><i class='bx bxs-folder'></i><span class='bold'>$key</span></div><ul>"; 
            $html_folder .= getFiles($values, $projectId, $next_dir);
            $html_folder .= "</ul></li>";
        }
    }
    finfo_close($finfo);
    return $html_folder . $html_files;
}

/**
 * Check $_FILES[][name]
 *
 * @param (string) $filename - Uploaded file name.
 * @author Yousef Ismaeil Cliprz
 */
function check_file_uploaded_name($filename)
{
    return (bool) ((preg_match("`^[-0-9A-Z_\.]+$`i", $filename)) ? true : false);
}

/**
 * Check $_FILES[][name] length.
 *
 * @param (string) $filename - Uploaded file name.
 * @author Yousef Ismaeil Cliprz.
 */
function check_file_uploaded_length($filename)
{
    return (bool) ((mb_strlen($filename, "UTF-8") > 225) ? true : false);
}

# Functions from https://gist.github.com/bubba-h57/5117694
/**
 * A Recursive directory move that allows exclusions. The excluded items in the src will be deleted
 * rather than moved.
 *
 * @param string $sourceDir    		The fully qualified source directory to copy
 * @param string $targetDir			The fully qualified destination directory to copy to
 * @param array $exclusions			An array of preg_match patterns to ignore in the copy process
 * @throws InvalidArgumentException
 * @throws ErrorException
 * @return boolean					Returns TRUE on success, throws an error otherwise.
 */

function rmove($src, $dest, $exclusions = array())
{
    // If source is not a directory stop processing
    if (!is_dir($src)) throw new InvalidArgumentException('The source passed in does not appear to be a valid directory: [' . $src . ']', 1);

    // If the destination directory does not exist create it
    if (!is_dir($dest)) {
        if (!mkdir($dest, 0, true)) {
            throw new InvalidArgumentException('The destination does not exist, and I can not create it: [' . $dest . ']', 2);
        }
    }

    // Ensure enclusions parameter is an array.
    if (! is_array($exclusions)) throw new InvalidArgumentException('The exclustion parameter is not an array, it MUST be an array.', 3);
    $emptiedDirs = array();

    // Open the source directory to read in files
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($src, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $f) {
        // Check to see if we should ignore this file or directory
        foreach ($exclusions as $pattern) {
            if (preg_match($pattern, $f->getRealPath())) {
                if ($f->isFile()) {
                    if (! unlink($f->getRealPath()))  throw new ErrorException("Failed to delete file [{$f->getRealPath()}] ", 4);
                } elseif ($f->isDir()) {
                    // we will attempt deleting these after we have moved all the files.
                    array_push($emptiedDirs, $f->getRealPath());
                }

                // Because we have to jump up two foreach levels
                continue 2;
            }
        }

        // We need to get a path relative to where we are copying from
        $relativePath = str_replace($src, '', $f->getRealPath());

        // And we can create a destination now.
        $destination = $dest . $relativePath;

        // if it is a file, lets just move that sucker over
        if ($f->isFile()) {
            $path_parts = pathinfo($destination);

            // If we don't have a directory for this yet
            if (! is_dir($path_parts['dirname'])) {
                // Lets create one!
                if (! mkdir($path_parts['dirname'], 0, true)) throw new ErrorException("Failed to create the destination directory: [{$path_parts['dirname']}]", 5);
            }

            if (! rename($f->getRealPath(), $destination)) throw new ErrorException("Failed to rename file [{$f->getRealPath()}] to [$destination]", 6);

            // if it is a directory, lets handle it
        } elseif ($f->isDir()) {
            // Check to see if the destination directory already exists
            if (! is_dir($destination)) {
                if (! mkdir($destination, 0, true)) throw new ErrorException("Failed to create the destination directory: [$destination]", 7);
            }
            // we will attempt deleting these after we have moved all the files.
            array_push($emptiedDirs, $f->getRealPath());
            // if it is something else, throw a fit. Symlinks can potentially end up here. I haven't tested them yet, but I think isFile() will typically
            // just pick them up and work
        } else {
            throw new ErrorException("I found [{$f->getRealPath()}] yet it appears to be neither a directory nor a file. [{$f->isDot()}] I don't know what to do with that!", 8);
        }
    }

    foreach ($emptiedDirs as $emptyDir) {
        print "Deleting $emptyDir\n";
        if (realpath($emptyDir) == realpath($src)) {
            continue;
        }
        if (!is_readable($emptyDir)) throw new ErrorException("The source directory: [$emptyDir] is not Readable", 9);

        // Delete the old directory
        if (! rmdir($emptyDir)) {
            // The directory is empty, we should have successfully deleted it.
            if ((count(scandir($emptyDir)) == 2)) {
                throw new ErrorException("Failed to delete the source directory: [$emptyDir]", 10);
            }
        }
    }

    // Finally, delete the base of the source directory we just recursed through
    if (! rmdir($src)) throw new ErrorException("Failed to delete the base source directory: [$src]", 11);
    return true;
}

/**
 * Wraps up our recursive move so that we get the error reporting we desire.
 *
 * @param string $sourceDir  The fully qualified source directory to copy
 * @param string $targetDir	The fully qualified destination directory to copy to
 * @param array $exclusions	An array of preg_match patterns to ignore in the copy process
 */

function rmoveWrapper($sourceDir, $targetDir, $exclusions = array())
{
    try {
        rmove($sourceDir, $targetDir, $exclusions);
    } catch (Exception $e) {
        switch ($e->getCode()) {
            case 1:
                print "ERROR: Source Directory [$sourceDir] doesn't exist or isn't a directory, we can't copy it to [$targetDir] if it isn't there.\n";
                break;
            case 2:
                print "ERROR: Destination Directory [$targetDir] doesn't exist and we can't create it.\n";
                break;
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:
            case 8:
            case 9:
            case 10:
            case 11:
                echo "ERROR: " . $e->getMessage() . "\n";
                break;
            default:
                print "ERROR: Something went sideways with copying the [$sourceDir] directory to [$targetDir].\n";
                print $e->getMessage() . "\n";
                print $e->getTraceAsString() . "\n";
        }
        print $e->getMessage() . "\n";
        print $e->getTraceAsString() . "\n";
    }
}
