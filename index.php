<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Share</title>
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
  </head>

  <body>
    <div class="form">
      <ul class="tab-group">
        <li class="tab active"><a href="#upload">Upload</a></li>
        <li class="tab"><a href="#files">File Types</a></li>
      </ul>
      <div class="tab-content">
        <div id="upload">   
          <h1>File Sharing By ro0ti</h1>
          <?php
            require "./config.php";
            function LoadUpload() {
              global $Allowed_File_Types,$Allowed_Uploads_At_Once,$Max_File_Size_KB;
              print "<form action=\"". htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES) ."\" method=\"post\" enctype=\"multipart/form-data\">\n";
              for($i=0; $i < $Allowed_Uploads_At_Once; $i++) {
                print "<p><input class=\"responsetext\" type=\"file\" name=\"file[]\" /></p>\n";
              }
              print "<p><input type=\"hidden\" name=\"upload\" value=\"1\" /><input type=\"submit\" value=\"Upload\" /></p>\n</form>\n";
            }
            $queueFiles = array();
            if(isset($_POST['upload'])) {
              for($i=0; $i < $Allowed_Uploads_At_Once; $i++) {
                if(strlen($_FILES['file']['name'][$i]) > 0) {
                  $filearray = explode(".", $_FILES['file']['name'][$i]);
                  $ext = end($filearray);
                  if($Force_File_Rename == true) {
                    list($usec, $sec) = explode(" ", microtime());
                    $queueFiles[$i] = $sec."_".$usec;
                  } else {
                    $xperiods = str_replace("." . $ext, "", $_FILES['file']['name'][$i]);
                    $queueFiles[$i] = str_replace(".", "", $xperiods);
                  }
                     
                  if(!in_array(strtolower($ext), $Allowed_File_Types)) {
                    print "<p class=\"error\"><strong>Disallowed Extension</strong><br /> ". htmlspecialchars($_FILES['file']['name'][$i]) ."<br />ERROR: File type not allowed.</p>\n";
                  } elseif($_FILES['file']['size'][$i] > ($Max_File_Size_KB*1024)) {
                    print "<p class=\"error\"><strong>File Too Big</strong><br /> ". htmlspecialchars($_FILES['file']['name'][$i]) ."<br />ERROR: File size to large.</p>\n";
                  } elseif(file_exists($Upload_Location.$queueFiles[$i] .".". $ext)) {
                    print "<p class=\"error\"><strong>File Exists</strong><br /> ". htmlspecialchars($queueFiles[$i]) .".". $ext ."<br />ERROR: File already exists.</p>\n";
                  } else {
                    if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $Upload_Location.$queueFiles[$i] .".". $ext)) {
                      print '<input class="responsetext" style="width: 100%;float: center;" value="' . $Website_Link . 'file/' . htmlspecialchars($queueFiles[$i]) .'.'. $ext .'"></p>';
                    } else {
                      print "<p class=\"error\"><strong>Error</strong><br /> ". htmlspecialchars($_FILES['file']['name'][$i]) ."<br />ERROR: Undetermined.</p>\n";
                    }
                  }
                }
              }
              LoadUpload();
            } else {
              LoadUpload();
            }
                     
            ?>
          </div>
        <div id="files">   
          <h1 color="#8D3A37"><strong>.</strong><span color="#ccc">zip</span></h1>
          <h1 color="#8D3A37"><strong>.</strong><span color="#ccc">rar</span></h1>
          <h1 color="#8D3A37"><strong>.</strong><span color="#ccc">mp3</span></h1>
          <h1 color="#8D3A37"><strong>.</strong><span color="#ccc">psd</span></h1>
          <h1 color="#8D3A37"><strong>.</strong><span color="#ccc">html</span></h1>
          <h1 color="#8D3A37"><strong>.</strong><span color="#ccc">txt</span></h1>
          <h1 color="#8D3A37"><strong>.</strong><span color="#ccc">pdf</span></h1>
          <h1 color="#8D3A37"><strong>.</strong><span color="#ccc">jpg</span></h1>
          <h1 color="#8D3A37"><strong>.</strong><span color="#ccc">png</span></h1>
          <h1 color="#8D3A37"><strong>.</strong><span color="#ccc">jpeg</span></h1>
          <h1 color="#8D3A37"><strong>.</strong><span color="#ccc">gif</span></h1>
          <h1 color="#8D3A37"><strong>.</strong><span color="#ccc">mp4</span></h1>
        </div>
      </div>
    </div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="js/index.js"></script>
  </body>
</html>
