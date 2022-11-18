<?php class Directories {

    function Create(string $folderName, string $content) {

        $root = __DIR__;
        if(is_dir("$root/directories/$folderName")) 
            return "<p>A directory already exists with that name</p>";
        else if (mkdir("$root/directories/$folderName", 0777) == false)
            return "<p>Unable to create directory</p>";
        
        chmod("$root/directories/$folderName", 0777);
        $handle = fopen("$root/directories/$folderName/readme.txt", "w" );
        fwrite($handle, $content);
        fclose($handle);
        return "<p>File and directory were created</p><a href='directories/$folderName/readme.txt'>Path to where the file is located</a>";
    }
    
} ?>