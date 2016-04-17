<!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
      <?php
        
        echo "<div STYLE='height: 500px; width: 400px; font-size: 12px; overflow: auto;'>";
        $i=0;
        while($i<count($playlistid))
        {        
          echo $playlistname[$i]."<br>";    
          $query = "SELECT mediaid  FROM playlist_media WHERE playlistid = '".$playlistid[$i]."';";
          $result = mysql_query($query) or die("Could not access playlist_media".mysql_error());
          $j=0;          
          while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
            $mediaid_array[] = $row[0];
            $j++;
          }
          $k=0;
          while($k<count($mediaid_array)){ 
            $query = "SELECT title, username, type, mediaid, path  FROM media WHERE mediaid = '".$mediaid_array[$k]."';";             
            $result = mysql_query($query) or die("error");
            while($row=mysql_fetch_array($result)){
              $title = $row[0];
              $username = $row[1];
              $type = $row[2];
              $mediaid = $row[3];
              $path = $row[4];          
              echo "  <li>";
              echo "    <video width='320' height='240' controls>";
              echo "      <source src=".$path." type =".$type." >";            
              echo "    </video>";
              echo "  </li>";
              echo $title;  
            }
            $k++;
          }          
          $i++;
        }
        echo "</div>";         
      ?>